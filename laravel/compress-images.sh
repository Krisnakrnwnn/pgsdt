#!/bin/bash

# Image Compression Script for Lighthouse 100% Performance
# This script compresses all images in storage/app/public/agendas

echo "🖼️  Image Compression Script"
echo "================================"
echo ""

# Check if ImageMagick is installed
if ! command -v convert &> /dev/null; then
    echo "❌ ImageMagick not found!"
    echo "Install it with: sudo apt-get install imagemagick"
    exit 1
fi

# Navigate to agendas folder
AGENDAS_DIR="storage/app/public/agendas"

if [ ! -d "$AGENDAS_DIR" ]; then
    echo "❌ Directory not found: $AGENDAS_DIR"
    exit 1
fi

cd "$AGENDAS_DIR" || exit

echo "📁 Working directory: $(pwd)"
echo ""

# Count images
TOTAL=$(find . -maxdepth 1 -type f \( -iname "*.jpg" -o -iname "*.jpeg" -o -iname "*.png" \) | wc -l)

if [ "$TOTAL" -eq 0 ]; then
    echo "ℹ️  No images found to compress"
    exit 0
fi

echo "Found $TOTAL images to compress"
echo ""

# Process each image
COUNT=0
SAVED=0

for img in *.jpg *.jpeg *.png 2>/dev/null; do
    # Skip if no files match
    [ -e "$img" ] || continue
    
    COUNT=$((COUNT + 1))
    
    # Get original size
    ORIGINAL_SIZE=$(stat -f%z "$img" 2>/dev/null || stat -c%s "$img" 2>/dev/null)
    ORIGINAL_KB=$((ORIGINAL_SIZE / 1024))
    
    echo "[$COUNT/$TOTAL] Processing: $img ($ORIGINAL_KB KB)"
    
    # Skip if already small
    if [ "$ORIGINAL_KB" -lt 300 ]; then
        echo "  ✓ Already optimized (< 300 KB), skipping"
        echo ""
        continue
    fi
    
    # Create backup
    cp "$img" "${img}.backup"
    
    # Compress image
    # - Resize to max 1200px width (maintains aspect ratio)
    # - Quality 85% (good balance between size and quality)
    # - Strip metadata
    # - Progressive JPEG for faster loading
    convert "$img" \
        -resize '1200>' \
        -quality 85 \
        -strip \
        -interlace Plane \
        "$img.tmp"
    
    # Check if compression was successful
    if [ $? -eq 0 ]; then
        # Get new size
        NEW_SIZE=$(stat -f%z "$img.tmp" 2>/dev/null || stat -c%s "$img.tmp" 2>/dev/null)
        NEW_KB=$((NEW_SIZE / 1024))
        SAVED_KB=$((ORIGINAL_KB - NEW_KB))
        SAVED=$((SAVED + SAVED_KB))
        PERCENT=$((100 - (NEW_KB * 100 / ORIGINAL_KB)))
        
        # Replace original with compressed
        mv "$img.tmp" "$img"
        
        echo "  ✓ Compressed: $ORIGINAL_KB KB → $NEW_KB KB (saved $SAVED_KB KB, -$PERCENT%)"
    else
        echo "  ❌ Failed to compress, keeping original"
        rm -f "$img.tmp"
    fi
    
    echo ""
done

echo "================================"
echo "✅ Compression complete!"
echo ""
echo "📊 Summary:"
echo "  - Images processed: $COUNT"
echo "  - Total saved: $SAVED KB (~$((SAVED / 1024)) MB)"
echo ""
echo "💡 Tip: Backups saved as *.backup"
echo "   To restore: mv image.jpg.backup image.jpg"
echo ""
echo "🚀 Next steps:"
echo "  1. Run Lighthouse test again"
echo "  2. Check performance score (should be 95-100%)"
echo "  3. If satisfied, delete backups: rm *.backup"
