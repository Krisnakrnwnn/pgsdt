<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AgendaRegistrationController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\AgendaController as AdminAgendaController;
use App\Http\Controllers\Admin\AgendaRegistrationController as AdminAgendaRegistrationController;
use App\Http\Middleware\IsAdmin;

Route::get('/api/wilayah/regencies', function () {
    $paths = [
        public_path('data/regencies-51.json'),
        base_path('../public_html/data/regencies-51.json'),
        base_path('public/data/regencies-51.json'),
        realpath(__DIR__ . '/../public/data/regencies-51.json')
    ];

    $path = null;
    foreach ($paths as $p) {
        if ($p && file_exists($p)) {
            $path = $p;
            break;
        }
    }
    
    if (!$path) abort(404, 'Data regencies tidak ditemukan. Pastikan folder data ada di public_html.');
    
    return response(file_get_contents($path))
        ->header('Content-Type', 'application/json')
        ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
        ->header('Pragma', 'no-cache');
});

Route::get('/api/wilayah/districts/{regencyId}', function ($regencyId) {
    $regencyId = preg_replace('/[^0-9]/', '', $regencyId);
    $paths = [
        public_path("data/districts-{$regencyId}.json"),
        base_path("../public_html/data/districts-{$regencyId}.json"),
        base_path("public/data/districts-{$regencyId}.json"),
        realpath(__DIR__ . "/../public/data/districts-{$regencyId}.json")
    ];

    $path = null;
    foreach ($paths as $p) {
        if ($p && file_exists($p)) {
            $path = $p;
            break;
        }
    }
    
    if (!$path) return response()->json([]);
    
    return response(file_get_contents($path))
        ->header('Content-Type', 'application/json')
        ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
        ->header('Pragma', 'no-cache');
});

Route::get('/api/wilayah/villages/{districtId}', function ($districtId) {
    $districtId = preg_replace('/[^0-9]/', '', $districtId);
    $paths = [
        public_path("data/villages-{$districtId}.json"),
        base_path("../public_html/data/villages-{$districtId}.json"),
        base_path("public/data/villages-{$districtId}.json"),
        realpath(__DIR__ . "/../public/data/villages-{$districtId}.json")
    ];

    $path = null;
    foreach ($paths as $p) {
        if ($p && file_exists($p)) {
            $path = $p;
            break;
        }
    }
    
    if (!$path) return response()->json([]);
    
    return response(file_get_contents($path))
        ->header('Content-Type', 'application/json')
        ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
        ->header('Pragma', 'no-cache');
});

Route::get('/', function () {
    // Temporarily disable cache to avoid serialization issues
    $latestNews = \App\Models\News::with('images')
        ->where('status', 'published')
        ->latest()
        ->take(3)
        ->get();
    
    $latestEvent = \App\Models\Agenda::where('is_featured', true)->first() 
                   ?? \App\Models\Agenda::where('status', 'upcoming')
                                         ->where('event_date', '>=', now())
                                         ->orderBy('event_date', 'asc')
                                         ->first();
    
    return view('pages.home', compact('latestNews', 'latestEvent'));
});

Route::get('/robots.txt', function () {
    $content = "User-agent: *
Allow: /
Disallow: /admin
Disallow: /login
Disallow: /profile
Disallow: /profile/edit
Disallow: /email/verify
Disallow: /forgot-password
Disallow: /reset-password
Disallow: /events/*/register

Sitemap: " . url('/sitemap.xml');

    return response($content)->header('Content-Type', 'text/plain');
});

Route::get('/sitemap.xml', function () {
    $cacheKey = 'sitemap_xml';
    $cacheDuration = 86400; // 24 hours
    
    $content = \Illuminate\Support\Facades\Cache::remember($cacheKey, $cacheDuration, function () {
        $news = \App\Models\News::where('status', 'published')->latest()->get();
        $agendas = \App\Models\Agenda::where('status', 'upcoming')->latest()->get();
        
        return view('sitemap', compact('news', 'agendas'))->render();
    });
    
    return response($content)->header('Content-Type', 'text/xml');
});

Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/events', [AgendaController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [AgendaController::class, 'show'])->name('events.show');
Route::get('/events/{slug}/register', [AgendaRegistrationController::class, 'create'])->name('events.register')->middleware(['auth']);
Route::post('/events/{slug}/register', [AgendaRegistrationController::class, 'store'])->name('events.register.store')->middleware(['auth']);

// Agenda popup registration after user registration
Route::post('/api/agenda/register-popup', [\App\Http\Controllers\AgendaPopupController::class, 'registerFromPopup'])->name('agenda.popup.register')->middleware(['auth']);

Route::get('/heritage', function () {
    return view('pages.heritage');
});

Route::get('/member', function () {
    return view('pages.member');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware(['guest', 'throttle:5,1']);
Route::post('/register', [AuthController::class, 'register'])->middleware(['guest', 'throttle:3,1']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/profile', [AuthController::class, 'profile'])->name('profile')->middleware('auth');
Route::get('/profile/edit', [AuthController::class, 'editProfile'])->name('profile.edit')->middleware('auth');
Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update')->middleware(['auth', 'throttle:10,1']);

// Google OAuth Routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google')->middleware('throttle:5,1');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->middleware('throttle:10,1');

// Password Reset Routes
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (\Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = \Illuminate\Support\Facades\Password::sendResetLink(
        $request->only('email')
    );

    return $status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT
        ? back()->with('status', 'Tautan reset kata sandi telah dikirim ke email Anda. Silakan periksa kotak masuk.')
        : back()->withErrors(['email' => 'Email tidak ditemukan dalam sistem kami.']);
})->middleware(['guest', 'throttle:5,1'])->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'token'    => 'required',
        'email'    => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = \Illuminate\Support\Facades\Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (\App\Models\User $user, string $password) {
            $user->forceFill([
                'password' => \Illuminate\Support\Facades\Hash::make($password),
            ])->save();

            event(new \Illuminate\Auth\Events\PasswordReset($user));
        }
    );

    return $status === \Illuminate\Support\Facades\Password::PASSWORD_RESET
        ? redirect()->route('login')->with('success', 'Kata sandi berhasil diubah. Silakan masuk dengan kata sandi baru Anda.')
        : back()->withErrors(['email' => 'Token tidak valid atau sudah kedaluwarsa. Silakan minta tautan baru.']);
})->middleware('guest')->name('password.store');


Route::get('/email/verify', function () {
    if (auth()->user()->hasVerifiedEmail()) {
        return redirect('/');
    }
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    // Validasi signature dulu (cek expires & tampering)
    if (! $request->hasValidSignature()) {
        return redirect()->route('verification.notice')
            ->with('warning', 'Tautan verifikasi sudah kedaluwarsa atau tidak valid. Silakan minta tautan baru.');
    }

    // Cari user termasuk yang soft-deleted
    $user = \App\Models\User::withTrashed()->findOrFail($id);

    // Restore jika ter-soft-delete
    if ($user->trashed()) {
        $user->restore();
    }

    // Validasi hash
    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Tautan verifikasi tidak valid.');
    }

    // Sudah terverifikasi sebelumnya
    if ($user->hasVerifiedEmail()) {
        if (auth()->check()) {
            return redirect('/')->with('info', 'Email Anda sudah terverifikasi sebelumnya.');
        }
        return redirect()->route('login')->with('info', 'Email Anda sudah terverifikasi. Silakan login.');
    }

    // Tandai email sebagai terverifikasi
    $user->markEmailAsVerified();

    // Aktifkan member otomatis
    $user->member_status = 'active';
    $user->save();

    // Kirim notifikasi selamat datang
    $user->notify(new \App\Notifications\MemberVerifiedNotification('approved'));

    // Login jika belum
    if (! auth()->check()) {
        auth()->login($user);
    }

    return redirect('/')->with('success', 'Email berhasil diverifikasi! Akun Anda sekarang aktif.');
})->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Tautan verifikasi telah dikirim ulang!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::post('/email/cancel', [AuthController::class, 'cancelRegistration'])->middleware('auth')->name('verification.cancel');


// Admin Routes protected by basic role check
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/', function (Request $request) {
        $newsCount = \App\Models\News::count();
        $memberCount = \App\Models\User::where('role', 'member')->count();
        $pendingCount = \App\Models\User::where('role', 'member')->where('member_status', 'pending')->count();
        $eventCount = \App\Models\Agenda::where('event_date', '>=', now())->count();
        
        // Dynamic Recent Members Query
        $recentQuery = \App\Models\User::where('role', 'member');
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $recentQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('register_number', 'like', "%{$search}%");
            });
        }
        
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $recentMembers = $recentQuery->orderBy($sort, $direction)->take(5)->get();
        
        // Popular Events Stats
        $popularEvents = \App\Models\Agenda::where('event_date', '>=', now())
            ->where('status', 'upcoming')
            ->withCount('registrations')
            ->orderBy('registrations_count', 'desc')
            ->take(3)
            ->get();
        
        // Calculate Regional Stats (hanya member aktif)
        $kabupatenStats = \App\Models\User::where('role', 'member')
            ->where('member_status', 'active')
            ->whereNotNull('kabupaten')
            ->select('kabupaten', \DB::raw('count(*) as total'))
            ->groupBy('kabupaten')
            ->orderBy('total', 'desc')
            ->get();

        return view('admin.dashboard', compact('newsCount', 'memberCount', 'pendingCount', 'recentMembers', 'eventCount', 'kabupatenStats', 'popularEvents'));
    });
    
    Route::delete('news/images/{image}', [AdminNewsController::class, 'destroyImage'])->name('news.images.destroy');
    Route::resource('news', AdminNewsController::class);
    Route::patch('agendas/{agenda}/set-featured', [AdminAgendaController::class, 'setFeatured'])->name('agendas.set-featured');
    Route::get('agendas/{agenda}/registrations', [AdminAgendaRegistrationController::class, 'index'])->name('agendas.registrations');
    Route::patch('agendas/registrations/{registration}/status', [AdminAgendaRegistrationController::class, 'updateStatus'])->name('agendas.registrations.status');
    Route::delete('agendas/registrations/{registration}', [AdminAgendaRegistrationController::class, 'destroy'])->name('agendas.registrations.destroy');
    Route::resource('agendas', AdminAgendaController::class);
    Route::post('members/{member}/verify', [MemberController::class, 'verify'])->name('members.verify');
    Route::get('members/export', [MemberController::class, 'export'])->name('members.export');
    Route::resource('members', MemberController::class)->except(['create', 'store']);
});


