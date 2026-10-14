# Levanta Laravel + Vite con PHP 8.5 (herd-lite). Evita el PHP 8.2 de XAMPP en el PATH.
$herd = "$env:USERPROFILE\.config\herd-lite\bin"
if (-not (Test-Path "$herd\php.exe")) {
    Write-Error "No se encontró PHP en $herd. Instala PHP 8.4+ (php.new) o ajusta esta ruta."
    exit 1
}
$env:Path = "$herd;" + $env:Path
Set-Location $PSScriptRoot
Write-Host "Usando: $(php -v | Select-Object -First 1)" -ForegroundColor Green
if (-not (Test-Path "public/hot") -and -not (Test-Path "public/build/manifest.json")) {
    Write-Host "Compilando CSS/JS (npm run build)..." -ForegroundColor Yellow
    npm run build
}
composer run dev
