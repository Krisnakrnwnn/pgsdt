<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:1', 'max:255'],
        ]);

        // Cek apakah user ada dan tidak di-soft-delete
        $user = \App\Models\User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors([
                'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('admin');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]{16}$/', \Illuminate\Validation\Rule::unique('users', 'nik')->withoutTrashed()],
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users', 'email')->withoutTrashed()],
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'desa' => 'required|string',
        ]);

        // Generate register number yang unik — pakai loop untuk hindari collision
        do {
            $registerNumber = 'PGSDT-' . date('Ym') . str_pad(random_int(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (\App\Models\User::withTrashed()->where('register_number', $registerNumber)->exists());

        $user = \App\Models\User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'member',
            'phone' => $request->phone,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'desa' => $request->desa,
            'register_number' => $registerNumber,
            'member_status' => 'pending',
        ]);

        // Send email verification
        event(new \Illuminate\Auth\Events\Registered($user));

        // Kirim notifikasi ke semua admin
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\MemberRegisteredNotification($user));
        }

        Auth::login($user);

        return redirect()->route('verification.notice');
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
}
