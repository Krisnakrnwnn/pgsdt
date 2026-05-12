<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        return redirect('/login')->withErrors(['email' => 'Login manual telah dinonaktifkan. Silakan gunakan Google Login.']);
    }

    public function register(Request $request)
    {
        return redirect('/member')->withErrors(['email' => 'Pendaftaran manual telah dinonaktifkan. Silakan daftar menggunakan Google Login.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function profile()
    {
        $member = Auth::user();
        return view('pages.profile', compact('member'));
    }

    public function editProfile()
    {
        $member = Auth::user();
        return view('pages.profile-edit', compact('member'));
    }

    public function updateProfile(Request $request)
    {
        $user = \App\Models\User::find(Auth::id());
        
        $request->validate([
            'name'      => 'required|string|max:255|regex:/^[\pL\s\-\.]+$/u',
            'nik'       => ['required', 'string', 'size:16', 'regex:/^[0-9]{16}$/', \Illuminate\Validation\Rule::unique('users', 'nik')->ignore($user->id)->withoutTrashed()],
            'phone'     => 'nullable|string|max:20|regex:/^[0-9\+\-\s]+$/',
            'kabupaten' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'desa'      => 'required|string|max:100',
            'image'     => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            ],
        ]);

        if ($request->hasFile('image')) {
            if ($user->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->image_path);
            }
            $user->image_path = $request->file('image')->store('members', 'public');
        }

        $user->name = $request->name;
        $user->nik = $request->nik;
        $user->phone = $request->phone;
        $user->kabupaten = $request->kabupaten;
        $user->kecamatan = $request->kecamatan;
        $user->desa = $request->desa;
        $user->save();

        // Trigger agenda popup after saving changes
        // Only if user is not already registered for the upcoming agenda
        $upcomingAgenda = \App\Models\Agenda::where('status', 'upcoming')
            ->where('registration_enabled', true)
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->first();

        if ($upcomingAgenda) {
            $isAlreadyRegistered = \App\Models\AgendaRegistration::where('agenda_id', $upcomingAgenda->id)
                ->where('user_id', $user->id)
                ->exists();

            if (!$isAlreadyRegistered) {
                $request->session()->put('show_agenda_popup', true);
                $request->session()->put('agenda_for_popup', [
                    'id' => $upcomingAgenda->id,
                    'title' => $upcomingAgenda->title,
                    'slug' => $upcomingAgenda->slug,
                    'event_date' => $upcomingAgenda->event_date->isoFormat('D MMMM Y'),
                    'location' => $upcomingAgenda->location,
                ]);
            }
        }

        return redirect()->route('profile')->with('success', 'Profil Anda berhasil diperbarui.');
    }

    public function cancelRegistration(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        // Flash current data to session to pre-fill the registration form
        $request->session()->flash('_old_input', [
            'name' => $user->name,
            'email' => $user->email,
            'nik' => $user->nik,
            'phone' => $user->phone,
            'kabupaten' => $user->kabupaten,
            'kecamatan' => $user->kecamatan,
            'desa' => $user->desa,
        ]);

        Auth::logout();
        
        // Force delete the unverified user to free up the NIK and email
        $user->forceDelete();

        return redirect('/member')->with('success', 'Silakan perbaiki data pendaftaran Anda.');
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists with this google_id
            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                // If user exists, update token and log them in
                $user->update([
                    'google_token' => $googleUser->token,
                ]);
                
                // Also ensure email is verified since they logged in via Google
                if (!$user->hasVerifiedEmail()) {
                    $user->markEmailAsVerified();
                }

                if ($user->member_status !== 'active') {
                    $user->member_status = 'active';
                    $user->save();
                }

                Auth::login($user);
                return redirect()->intended(Auth::user()->role === 'admin' ? 'admin' : '/');
            }

            // If google_id doesn't exist, check by email
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // Link google_id to existing account
                $user->update([
                    'google_id' => $googleUser->id,
                    'google_token' => $googleUser->token,
                ]);

                if (!$user->hasVerifiedEmail()) {
                    $user->markEmailAsVerified();
                }

                if ($user->member_status !== 'active') {
                    $user->member_status = 'active';
                    $user->save();
                }

                Auth::login($user);
            } else {
                // Jika ada user yang sudah di-soft-delete dengan email yang sama,
                // hapus permanen agar bisa buat akun baru via Google
                User::withTrashed()
                    ->where('email', $googleUser->email)
                    ->whereNotNull('deleted_at')
                    ->forceDelete();

                // Create a new user
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'google_token' => $googleUser->token,
                    'role' => 'member',
                    'member_status' => 'active', // Langsung aktif
                    'password' => null, // No local password
                    'email_verified_at' => now(), // Langsung terverifikasi
                ]);

                // We might need to generate a register number here too
                do {
                    $registerNumber = 'PGSDT-' . date('Ym') . str_pad(random_int(1, 99999), 5, '0', STR_PAD_LEFT);
                } while (User::withTrashed()->where('register_number', $registerNumber)->exists());
                
                $user->update(['register_number' => $registerNumber]);

                Auth::login($user);
            }

            // Check if profile is complete (e.g. has NIK)
            if (!$user->nik) {
                return redirect()->route('profile.edit')->with('info', 'Harap lengkapi profil Anda (NIK, No. HP, dan Alamat) untuk menyelesaikan pendaftaran.');
            }

            return redirect()->intended('/');

        } catch (Exception $e) {
            return redirect('/login')->withErrors(['email' => 'Gagal masuk menggunakan Google. Silakan coba lagi.']);
        }
    }
}
