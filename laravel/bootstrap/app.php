<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');

        // Cache headers untuk static assets (images, fonts, CSS, JS)
        $middleware->append(\App\Http\Middleware\CacheHeaders::class);

        // Security headers untuk semua response
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);

        // No-cache untuk HTML agar tidak konflik cache antar project
        $middleware->append(\App\Http\Middleware\NoCacheHeaders::class);

        // Pastikan profil lengkap untuk member
        $middleware->web(append: [
            \App\Http\Middleware\CheckProfileCompletion::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
