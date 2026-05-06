#!/usr/bin/env php
<?php

/**
 * Image Compression Script
 * Compresses all images in storage/app/public/agendas
 */

echo "🖼️  Image Compression Script\n";
echo "================================\n\n";

$agendasDir = __DIR__ . '/storage/app/public/agendas';

if (!is_dir($agendasDir)) {
    echo "❌ Directory not found: $agendasDir\n";
    exit(1);
}

// Check if GD is available
if (!extension_loaded('gd')) {
    echo "❌ GD extension not found!\n";
    echo "Install it with: sudo apt-get install php-gd\n";
    echo "Or on Windows: Enable extension=gd in php.ini\n";
    exit(1);
}

echo "📁 Working directory: $agendasDir\n\n";

// Get all images
$images = glob($agendasDir . '/*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE);

if (empty($images)) {
    echo "ℹ️  No images found to compress\n";
    exit(0);
}

$total = count($images);
echo "Found $total images to compress\n\n";

$count = 0;
$totalSaved = 0;

foreach ($images as $imagePath) {
    $count++;
    $filename = basename($imagePath);
    
    // Get original size
    $originalSize = filesize($imagePath);
    $originalKB = round($originalSize / 1024, 2);
    
    echo "[$count/$total] Processing: $filename ($originalKB KB)\n";
    
    // Skip if already small
    if ($originalKB < 300) {
        echo "  ✓ Already optimized (< 300 KB), skipping\n\n";
        continue;
    }
    
    // Create backup
    $backupPath = $imagePath . '.backup';
    copy($imagePath, $backupPath);
    
    // Determine image type
    $imageInfo = getimagesize($imagePath);
    $mimeType = $imageInfo['mime'];
    
    // Load image
    $image = null;
    switch ($mimeType) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($imagePath);
            break;
        case 'image/png':
            $image = imagecreatefrompng($imagePath);
            break;
        default:
            echo "  ⚠️  Unsupported format, skipping\n\n";
            continue 2;
    }
    
    if (!$image) {
        echo "  ❌ Failed to load image\n\n";
        continue;
    }
    
    // Get dimensions
    $width = imagesx($image);
    $height = imagesy($image);
    
    // Resize if too large (max 1200px width)
    $maxWidth = 1200;
    if ($width > $maxWidth) {
        $newWidth = $maxWidth;
        $newHeight = (int)($height * ($maxWidth / $width));
        
        $resized = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preserve transparency for PNG
        if ($mimeType === 'image/png') {
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
        }
        
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($image);
        $image = $resized;
    }
    
    // Save compressed image
    $success = false;
    if ($mimeType === 'image/jpeg' || $mimeType === 'image/jpg') {
        $success = imagejpeg($image, $imagePath, 85); // 85% quality
    } elseif ($mimeType === 'image/png') {
        $success = imagepng($image, $imagePath, 6); // Compression level 6
    }
    
    imagedestroy($image);
    
    if ($success) {
        // Get new size
        $newSize = filesize($imagePath);
        $newKB = round($newSize / 1024, 2);
        $savedKB = round($originalKB - $newKB, 2);
        $totalSaved += $savedKB;
        $percent = round(100 - ($newKB * 100 / $originalKB), 0);
        
        echo "  ✓ Compressed: $originalKB KB → $newKB KB (saved $savedKB KB, -$percent%)\n";
    } else {
        echo "  ❌ Failed to compress, restoring backup\n";
        copy($backupPath, $imagePath);
    }
    
    echo "\n";
}

echo "================================\n";
echo "✅ Compression complete!\n\n";
echo "📊 Summary:\n";
echo "  - Images processed: $count\n";
echo "  - Total saved: $totalSaved KB (~" . round($totalSaved / 1024, 2) . " MB)\n\n";
echo "💡 Tip: Backups saved as *.backup\n";
echo "   To restore: mv image.jpg.backup image.jpg\n\n";
echo "🚀 Next steps:\n";
echo "  1. Restart server: php artisan serve\n";
echo "  2. Clear browser cache: Ctrl+Shift+Delete\n";
echo "  3. Run Lighthouse test again\n";
echo "  4. If satisfied, delete backups: rm storage/app/public/agendas/*.backup\n";
