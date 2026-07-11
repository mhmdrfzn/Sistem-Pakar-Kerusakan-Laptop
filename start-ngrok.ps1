# ============================================
# LaptopExpert AI - Start with Ngrok
# ============================================
# Jalankan script ini di PowerShell:
#   .\start-ngrok.ps1
# ============================================

Write-Host ""
Write-Host "  LaptopExpert AI — Ngrok Launcher" -ForegroundColor Cyan
Write-Host "  ====================================" -ForegroundColor Cyan
Write-Host ""

# Cek apakah pakai Laragon atau artisan serve
$useLaragon = $false
$port = 8000

Write-Host "  Pilih mode server:" -ForegroundColor Yellow
Write-Host "  [1] Laragon / Apache (port 80) - Jika Laragon sedang aktif"
Write-Host "  [2] php artisan serve (port 8000) - Jika tidak pakai Laragon"
Write-Host ""
$choice = Read-Host "  Pilihan (1/2)"

if ($choice -eq "1") {
    $useLaragon = $true
    $port = 80
    Write-Host ""
    Write-Host "  Mode: Laragon (port 80)" -ForegroundColor Green
    Write-Host "  Pastikan Laragon sudah aktif dan site sistempakar.test berjalan." -ForegroundColor Gray
} else {
    Write-Host ""
    Write-Host "  Mode: php artisan serve (port 8000)" -ForegroundColor Green
    Write-Host "  Menjalankan Laravel dev server..." -ForegroundColor Gray
    
    # Start artisan serve di background
    Start-Process powershell -ArgumentList "-NoExit", "-Command", "Set-Location 'c:\laragon\www\SistemPakar'; php artisan serve --host=127.0.0.1 --port=8000" -WindowStyle Normal
    
    Write-Host "  Menunggu server siap..." -ForegroundColor Gray
    Start-Sleep -Seconds 3
}

Write-Host ""
Write-Host "  Memulai ngrok tunnel di port $port..." -ForegroundColor Cyan

# Jalankan ngrok
if ($useLaragon) {
    Write-Host "  Command: ngrok http 80 --host-header=sistempakar.test" -ForegroundColor Gray
    Write-Host ""
    ngrok http 80 --host-header=sistempakar.test
} else {
    Write-Host "  Command: ngrok http 8000" -ForegroundColor Gray
    Write-Host ""
    ngrok http 8000
}
