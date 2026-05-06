<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Perbaikan Path Maintenance
if (file_exists($maintenance = __DIR__.'/../laravel/storage/framework/maintenance.php')) {
    require $maintenance;
}

// 2. Register Autoloader
require __DIR__.'/../laravel/vendor/autoload.php';

// 3. Bootstrap Laravel
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';

// 4. Set Public Path (Agar Laravel tahu folder publiknya adalah public_html)
$app->usePublicPath(__DIR__);

// 5. Jalankan Aplikasi (INI YANG TADI KURANG)
$app->handleRequest(Request::capture());
