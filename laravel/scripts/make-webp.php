<?php
// Konversi Logo-60.png ke WebP
if (function_exists('imagewebp')) {
    $src = imagecreatefrompng('public/assets/Logo-60.png');
    imagewebp($src, 'public/assets/Logo-60.webp', 85);
    echo 'Logo-60.webp: ' . round(filesize('public/assets/Logo-60.webp')/1024, 1) . "KB\n";
    echo 'Logo-60.png: ' . round(filesize('public/assets/Logo-60.png')/1024, 1) . "KB\n";
} else {
    echo "WebP not supported, skipping\n";
}
