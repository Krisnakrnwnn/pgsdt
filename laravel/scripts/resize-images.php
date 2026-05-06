<?php
// Resize Logo.png ke 200x200 untuk navbar/favicon
$src = imagecreatefrompng('public/assets/Logo.png');
$dst = imagecreatetruecolor(200, 200);
imagealphablending($dst, false);
imagesavealpha($dst, true);
$transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
imagefilledrectangle($dst, 0, 0, 200, 200, $transparent);
imagecopyresampled($dst, $src, 0, 0, 0, 0, 200, 200, 1412, 1412);
imagepng($dst, 'public/assets/Logo-sm.png', 9);
imagedestroy($src);
imagedestroy($dst);
echo 'Logo-sm.png: ' . round(filesize('public/assets/Logo-sm.png')/1024, 1) . "KB\n";

// Resize heritage_hero.png ke 1920x1080 max
$info = getimagesize('public/assets/heritage_hero.png');
$origW = $info[0];
$origH = $info[1];
$maxW = 1920;
$ratio = $maxW / $origW;
$newW = $maxW;
$newH = (int)($origH * $ratio);

$src2 = imagecreatefrompng('public/assets/heritage_hero.png');
$dst2 = imagecreatetruecolor($newW, $newH);
imagecopyresampled($dst2, $src2, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
imagepng($dst2, 'public/assets/heritage_hero-opt.png', 8);
imagedestroy($src2);
imagedestroy($dst2);
echo 'heritage_hero-opt.png: ' . round(filesize('public/assets/heritage_hero-opt.png')/1024, 1) . "KB\n";
echo "Original hero: " . round(filesize('public/assets/heritage_hero.png')/1024, 1) . "KB\n";
echo "Done!\n";
