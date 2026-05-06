# Image Compression Script for Lighthouse 100% Performance (Windows)
# This script compresses all images in storage/app/public/agendas

Write-Host "🖼️  Image Compression Script" -ForegroundColor Cyan
Write-Host "================================" -ForegroundColor Cyan
Write-Host ""

# Check if ImageMagick is installed
$magickPath = Get-Command magick -ErrorAction SilentlyContinue

if (-not $magickPath) {
    Write-Host "❌ ImageMagick not found!" -ForegroundColor Red
    Write-Host "Download from: https://imagemagick.org/script/download.php#windows" -ForegroundColor Yellow
    Write-Host "Or install with: winget install ImageMagick.ImageMagick" -ForegroundColor Yellow
    exit 1
}

# Navigate to agendas folder
$agendasDir = "storage\app\public\agendas"

if (-not (Test-Path $agendasDir)) {
    Write-Host "❌ Directory not found: $agendasDir" -ForegroundColor Red
    exit 1
}

Set-Location $agendasDir

Write-Host "📁 Working directory: $(Get-Location)" -ForegroundColor Green
Write-Host ""

# Get all images
$images = Get-ChildItem -File -Include *.jpg,*.jpeg,*.png

if ($images.Count -eq 0) {
    Write-Host "ℹ️  No images found to compress" -ForegroundColor Yellow
    exit 0
}

Write-Host "Found $($images.Count) images to compress" -ForegroundColor Green
Write-Host ""

# Process each image
$count = 0
$totalSaved = 0

foreach ($img in $images) {
    $count++
    
    # Get original size
    $originalSize = $img.Length
    $originalKB = [math]::Round($originalSize / 1KB, 2)
    
    Write-Host "[$count/$($images.Count)] Processing: $($img.Name) ($originalKB KB)" -ForegroundColor Cyan
    
    # Skip if already small
    if ($originalKB -lt 300) {
        Write-Host "  ✓ Already optimized (< 300 KB), skipping" -ForegroundColor Green
        Write-Host ""
        continue
    }
    
    # Create backup
    Copy-Item $img.FullName "$($img.FullName).backup"
    
    # Compress image
    $tempFile = "$($img.FullName).tmp"
    
    & magick convert $img.FullName `
        -resize "1200>" `
        -quality 85 `
        -strip `
        -interlace Plane `
        $tempFile
    
    # Check if compression was successful
    if (Test-Path $tempFile) {
        $newSize = (Get-Item $tempFile).Length
        $newKB = [math]::Round($newSize / 1KB, 2)
        $savedKB = [math]::Round($originalKB - $newKB, 2)
        $totalSaved += $savedKB
        $percent = [math]::Round(100 - ($newKB * 100 / $originalKB), 0)
        
        # Replace original with compressed
        Move-Item $tempFile $img.FullName -Force
        
        Write-Host "  ✓ Compressed: $originalKB KB → $newKB KB (saved $savedKB KB, -$percent%)" -ForegroundColor Green
    } else {
        Write-Host "  ❌ Failed to compress, keeping original" -ForegroundColor Red
    }
    
    Write-Host ""
}

Write-Host "================================" -ForegroundColor Cyan
Write-Host "✅ Compression complete!" -ForegroundColor Green
Write-Host ""
Write-Host "📊 Summary:" -ForegroundColor Cyan
Write-Host "  - Images processed: $count" -ForegroundColor White
Write-Host "  - Total saved: $totalSaved KB (~$([math]::Round($totalSaved / 1024, 2)) MB)" -ForegroundColor White
Write-Host ""
Write-Host "💡 Tip: Backups saved as *.backup" -ForegroundColor Yellow
Write-Host "   To restore: Move-Item image.jpg.backup image.jpg" -ForegroundColor Yellow
Write-Host ""
Write-Host "🚀 Next steps:" -ForegroundColor Cyan
Write-Host "  1. Run Lighthouse test again" -ForegroundColor White
Write-Host "  2. Check performance score (should be 95-100%)" -ForegroundColor White
Write-Host "  3. If satisfied, delete backups: Remove-Item *.backup" -ForegroundColor White
