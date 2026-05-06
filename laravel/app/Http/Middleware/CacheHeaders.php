<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Only apply to successful responses
        if ($response->getStatusCode() !== 200) {
            return $response;
        }
        
        $path = $request->path();
        
        // Storage files (images uploaded by users)
        if (str_starts_with($path, 'storage/')) {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            
            // Images: Cache 1 year
            if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg', 'ico'])) {
                $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
                $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
            }
        }
        
        return $response;
    }
}
