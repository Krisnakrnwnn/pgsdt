<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    // Add cache headers for static assets
    $extension = strtolower(pathinfo($uri, PATHINFO_EXTENSION));
    
    // Images: 1 year cache
    if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg', 'ico'])) {
        header('Cache-Control: public, max-age=31536000, immutable');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
    }
    // CSS/JS: 1 year cache
    elseif (in_array($extension, ['css', 'js'])) {
        header('Cache-Control: public, max-age=31536000, immutable');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
    }
    // Fonts: 1 year cache
    elseif (in_array($extension, ['woff', 'woff2', 'ttf', 'otf', 'eot'])) {
        header('Cache-Control: public, max-age=31536000, immutable');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
    }
    // JSON/Manifest: 1 week cache
    elseif (in_array($extension, ['json', 'webmanifest'])) {
        header('Cache-Control: public, max-age=604800');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 604800) . ' GMT');
    }
    
    return false;
}

require_once __DIR__.'/public/index.php';
