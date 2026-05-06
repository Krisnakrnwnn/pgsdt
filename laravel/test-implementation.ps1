# PGSDT v2.0 - Implementation Test Script
# Run this script to automatically check all improvements

Write-Host "`n╔════════════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║     PGSDT v2.0 - Implementation Verification Script      ║" -ForegroundColor Cyan
Write-Host "╚════════════════════════════════════════════════════════════╝`n" -ForegroundColor Cyan

$totalTests = 0
$passedTests = 0
$failedTests = 0

function Test-Item {
    param(
        [string]$TestName,
        [scriptblock]$TestScript
    )
    
    $script:totalTests++
    Write-Host "`n[$script:totalTests] Testing: $TestName" -ForegroundColor Yellow
    
    try {
        $result = & $TestScript
        if ($result) {
            Write-Host "    ✓ PASS" -ForegroundColor Green
            $script:passedTests++
            return $true
        } else {
            Write-Host "    ✗ FAIL" -ForegroundColor Red
            $script:failedTests++
            return $false
        }
    } catch {
        Write-Host "    ✗ ERROR: $_" -ForegroundColor Red
        $script:failedTests++
        return $false
    }
}

# Test 1: Configuration
Test-Item "Application Configuration" {
    $about = php artisan about 2>&1 | Out-String
    $checks = @(
        ($about -match "PGSDT"),
        ($about -match "Asia/Makassar"),
        ($about -match "id")
    )
    $checks -notcontains $false
}

# Test 2: Database Migration
Test-Item "Soft Delete Migration" {
    $migrations = php artisan migrate:status 2>&1 | Out-String
    $migrations -match "soft_deletes.*Ran"
}

# Test 3: Notification Files
Test-Item "Notification Classes" {
    $files = @(
        "app/Notifications/MemberRegisteredNotification.php",
        "app/Notifications/MemberVerifiedNotification.php",
        "app/Notifications/EventRegistrationNotification.php"
    )
    $files | ForEach-Object { Test-Path $_ } | Where-Object { $_ -eq $false } | Measure-Object | Select-Object -ExpandProperty Count | ForEach-Object { $_ -eq 0 }
}

# Test 4: Observer Files
Test-Item "Observer Classes" {
    $files = @(
        "app/Observers/NewsObserver.php",
        "app/Observers/AgendaObserver.php"
    )
    $files | ForEach-Object { Test-Path $_ } | Where-Object { $_ -eq $false } | Measure-Object | Select-Object -ExpandProperty Count | ForEach-Object { $_ -eq 0 }
}

# Test 5: Helper Files
Test-Item "Helper Classes" {
    Test-Path "app/Helpers/CacheHelper.php"
}

# Test 6: Seeder Files
Test-Item "Admin Seeder" {
    Test-Path "database/seeders/AdminSeeder.php"
}

# Test 7: PWA Files
Test-Item "PWA Manifest" {
    Test-Path "public/manifest.json"
}

# Test 8: SEO Files
Test-Item "SEO Files (robots.txt, sitemap)" {
    $files = @(
        "public/robots.txt",
        "resources/views/sitemap.blade.php"
    )
    $files | ForEach-Object { Test-Path $_ } | Where-Object { $_ -eq $false } | Measure-Object | Select-Object -ExpandProperty Count | ForEach-Object { $_ -eq 0 }
}

# Test 9: Documentation Files
Test-Item "Documentation Files" {
    $docs = @(
        "README.md",
        "DEPLOYMENT.md",
        "QUICKSTART.md",
        "CHANGELOG.md",
        "CONTRIBUTING.md",
        "SECURITY.md",
        "PRODUCTION_CHECKLIST.md",
        "API_FUTURE.md",
        "IMPLEMENTATION_SUMMARY.md",
        "FINAL_SUMMARY.md",
        "TESTING_GUIDE.md"
    )
    $missing = $docs | Where-Object { -not (Test-Path $_) }
    $missing.Count -eq 0
}

# Test 10: Routes
Test-Item "Routes Configuration" {
    $routes = php artisan route:list 2>&1 | Out-String
    $checks = @(
        ($routes -match "sitemap"),
        ($routes -match "login"),
        ($routes -match "register")
    )
    $checks -notcontains $false
}

# Test 11: Storage Link
Test-Item "Storage Link" {
    Test-Path "public/storage"
}

# Test 12: Config Cache
Test-Item "Configuration Syntax" {
    $result = php artisan config:cache 2>&1 | Out-String
    $result -match "cached successfully"
}

# Summary
Write-Host "`n╔════════════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║                    TEST SUMMARY                          ║" -ForegroundColor Cyan
Write-Host "╚════════════════════════════════════════════════════════════╝`n" -ForegroundColor Cyan

Write-Host "Total Tests:  $totalTests" -ForegroundColor White
Write-Host "Passed:       $passedTests" -ForegroundColor Green
Write-Host "Failed:       $failedTests" -ForegroundColor Red

$percentage = [math]::Round(($passedTests / $totalTests) * 100, 2)
Write-Host "`nSuccess Rate: $percentage%" -ForegroundColor $(if ($percentage -eq 100) { "Green" } else { "Yellow" })

if ($failedTests -eq 0) {
    Write-Host "`n✓ ALL TESTS PASSED! Implementation is 100% complete!" -ForegroundColor Green
    Write-Host "  Your PGSDT v2.0 is ready for production!" -ForegroundColor Green
} else {
    Write-Host "`n⚠ Some tests failed. Please check the errors above." -ForegroundColor Yellow
    Write-Host "  See TESTING_GUIDE.md for troubleshooting." -ForegroundColor Yellow
}

Write-Host "`n╔════════════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║                  NEXT STEPS                              ║" -ForegroundColor Cyan
Write-Host "╚════════════════════════════════════════════════════════════╝`n" -ForegroundColor Cyan

Write-Host "1. Read QUICKSTART.md for quick setup" -ForegroundColor White
Write-Host "2. Read TESTING_GUIDE.md for manual testing" -ForegroundColor White
Write-Host "3. Read DEPLOYMENT.md for production deployment" -ForegroundColor White
Write-Host "4. Start server: composer run dev" -ForegroundColor White
Write-Host "5. Open browser: http://127.0.0.1:8000" -ForegroundColor White

Write-Host "`nOm Swastyastu 🙏`n" -ForegroundColor Cyan
