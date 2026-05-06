<?php
// heritage_hero.png sebenarnya JPEG
$src = imagecreatefromjpeg('public/assets/heritage_hero.png');
$origW = imagesx($src);
$origH = imagesy($src);

// Resize ke 1440px lebar, pertahankan ratio
$newW = 1440;
$ratio = $newW / $origW;
$newH = (int)($origH * $ratio);

$dst = imagecreatetruecolor($newW, $newH);
imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);

// Simpan sebagai JPEG quality 80 (lebih kecil dari PNG)
imagejpeg($dst, 'public/assets/heritage_hero-opt.jpg', 80);

echo "Original: " . round(filesize('public/assets/heritage_hero.png')/1024, 1) . "KB\n";
echo "Optimized JPEG: " . round(filesize('public/assets/heritage_hero-opt.jpg')/1024, 1) . "KB\n";
echo "Dimensions: {$newW}x{$newH}\n";
