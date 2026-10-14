# Ejecuta artisan con PHP 8.5 (herd-lite), no el PHP 8.2 de XAMPP.
$herd = "$env:USERPROFILE\.config\herd-lite\bin"
if (-not (Test-Path "$herd\php.exe")) {
    Write-Error "No se encontró PHP en $herd. Usa dev.ps1 o instala PHP 8.4+."
    exit 1
}
$env:Path = "$herd;" + $env:Path
Set-Location $PSScriptRoot
php artisan @args
