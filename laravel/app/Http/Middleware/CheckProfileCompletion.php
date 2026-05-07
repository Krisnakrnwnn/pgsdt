<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckProfileCompletion
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Only check for authenticated users who are NOT admins
        if ($user && $user->role !== 'admin') {
            // Define required fields for a complete profile
            $requiredFields = ['nik', 'phone', 'kabupaten', 'kecamatan', 'desa'];
            
            $isIncomplete = false;
            foreach ($requiredFields as $field) {
                if (empty($user->$field)) {
                    $isIncomplete = true;
                    break;
                }
            }

            if ($isIncomplete) {
                // Allow access to profile edit, profile update, and logout
                $allowedRoutes = ['profile.edit', 'profile.update', 'logout'];
                if (!$request->routeIs($allowedRoutes)) {
                    return redirect()->route('profile.edit')
                        ->with('warning', 'Harap lengkapi profil Anda (NIK, No. HP, dan Alamat) sebelum melanjutkan.');
                }
            }
        }

        return $next($request);
    }
}
