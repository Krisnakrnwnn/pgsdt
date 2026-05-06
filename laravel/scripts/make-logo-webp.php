<?php
$src = imagecreatefrompng('public/assets/Logo-192.png');
imagewebp($src, 'public/assets/Logo-192.webp', 85);
echo 'Logo-192.webp: ' . round(filesize('public/assets/Logo-192.webp')/1024, 1) . "KB\n";
echo 'Logo-192.png: ' . round(filesize('public/assets/Logo-192.png')/1024, 1) . "KB\n";
