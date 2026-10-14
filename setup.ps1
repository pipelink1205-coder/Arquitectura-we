# Migraciones + datos iniciales (admin y contenido del sitio).
$herd = "$env:USERPROFILE\.config\herd-lite\bin"
if (-not (Test-Path "$herd\php.exe")) {
    Write-Error "No se encontró PHP en $herd."
    exit 1
}
$env:Path = "$herd;" + $env:Path
Set-Location $PSScriptRoot
Write-Host "Usando: $(php -v | Select-Object -First 1)" -ForegroundColor Green
php artisan migrate --force
php artisan db:seed --force
Write-Host "`nListo. Panel: http://127.0.0.1:8000/admin" -ForegroundColor Cyan
Write-Host "Correo: admin@we.local  |  Clave: WeAdmin2026!" -ForegroundColor Cyan
