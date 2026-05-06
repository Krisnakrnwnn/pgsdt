<?php
// Kompres heritage_hero-opt.jpg lebih agresif (quality 65)
$src = imagecreatefromjpeg('public/assets/heritage_hero-opt.jpg');
imagejpeg($src, 'public/assets/heritage_hero-opt.jpg', 65);
echo 'JPEG q65: ' . round(filesize('public/assets/heritage_hero-opt.jpg')/1024, 1) . "KB\n";

// Buat versi WebP (jauh lebih kecil)
if (function_exists('imagewebp')) {
    imagewebp($src, 'public/assets/heritage_hero-opt.webp', 75);
    echo 'WebP q75: ' . round(filesize('public/assets/heritage_hero-opt.webp')/1024, 1) . "KB\n";
}
