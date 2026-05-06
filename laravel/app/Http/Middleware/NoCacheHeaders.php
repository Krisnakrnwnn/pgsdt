<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoCacheHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $contentType = $response->headers->get('Content-Type', '');
        $uri = $request->getRequestUri();

        // Cache panjang untuk static assets (font, gambar, CSS, JS)
        $isStaticAsset = (bool) preg_match('/\.(woff2?|ttf|otf|png|jpg|jpeg|webp|gif|svg|ico|css|js)(\?.*)?$/', $uri);

        if ($isStaticAsset) {
            // Vite assets punya hash di nama file → cache 1 tahun
            // Font/gambar tanpa hash → cache 1 minggu
            $hasHash = (bool) preg_match('/[a-f0-9]{8,}/', basename(parse_url($uri, PHP_URL_PATH) ?? ''));
            $ttl = $hasHash ? 31536000 : 604800;
            $response->headers->set('Cache-Control', "public, max-age={$ttl}, immutable");
        } elseif (str_contains($contentType, 'text/html')) {
            // HTML: no-cache agar selalu fresh, tapi bfcache tetap bisa bekerja
            $response->headers->set('Cache-Control', 'no-cache, private');
            $response->headers->set('Pragma', 'no-cache');
        }

        return $response;
    }
}
