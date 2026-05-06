<?php
$src = imagecreatefrompng('public/assets/Logo.png');
$dst = imagecreatetruecolor(60, 60);
imagealphablending($dst, false);
imagesavealpha($dst, true);
$t = imagecolorallocatealpha($dst, 255, 255, 255, 127);
imagefilledrectangle($dst, 0, 0, 60, 60, $t);
imagecopyresampled($dst, $src, 0, 0, 0, 0, 60, 60, 1412, 1412);
imagepng($dst, 'public/assets/Logo-60.png', 9);
echo 'Logo-60.png: ' . round(filesize('public/assets/Logo-60.png')/1024, 1) . "KB\n";

// Juga buat 192x192 untuk PWA manifest
$dst2 = imagecreatetruecolor(192, 192);
imagealphablending($dst2, false);
imagesavealpha($dst2, true);
$t2 = imagecolorallocatealpha($dst2, 255, 255, 255, 127);
imagefilledrectangle($dst2, 0, 0, 192, 192, $t2);
imagecopyresampled($dst2, $src, 0, 0, 0, 0, 192, 192, 1412, 1412);
imagepng($dst2, 'public/assets/Logo-192.png', 9);
echo 'Logo-192.png: ' . round(filesize('public/assets/Logo-192.png')/1024, 1) . "KB\n";
