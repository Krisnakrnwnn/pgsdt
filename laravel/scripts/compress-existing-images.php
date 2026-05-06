<?php
// Kompres semua gambar berita yang ada di storage
$dir = 'storage/app/public/news_images';
$files = glob($dir . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
$totalSaved = 0;

foreach ($files as $file) {
    $sizeBefore = filesize($file);
    $mime = mime_content_type($file);

    if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
        $src = imagecreatefromjpeg($file);
    } elseif ($mime === 'image/png') {
        $src = imagecreatefrompng($file);
    } elseif ($mime === 'image/webp') {
        $src = imagecreatefromwebp($file);
    } else {
        continue;
    }

    $origW = imagesx($src);
    $origH = imagesy($src);
    $maxW  = 1200;

    if ($origW > $maxW) {
        $ratio = $maxW / $origW;
        $newW  = $maxW;
        $newH  = (int)($origH * $ratio);
        $dst   = imagecreatetruecolor($newW, $newH);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
    } else {
        $dst = $src;
    }

    // Simpan sebagai JPEG quality 80
    $outFile = preg_replace('/\.(png|webp|jpeg)$/i', '.jpg', $file);
    imagejpeg($dst, $outFile, 80);

    // Hapus file asli jika beda nama
    if ($outFile !== $file) {
        unlink($file);
    }

    $sizeAfter = filesize($outFile);
    $saved = $sizeBefore - $sizeAfter;
    $totalSaved += $saved;

    echo basename($file) . ': ' . round($sizeBefore/1024, 1) . 'KB → ' . round($sizeAfter/1024, 1) . "KB (saved " . round($saved/1024, 1) . "KB)\n";
}

echo "\nTotal saved: " . round($totalSaved/1024, 1) . "KB\n";
