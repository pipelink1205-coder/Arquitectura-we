<?php

use App\Http\Controllers\InicioController;
use App\Http\Controllers\SolicitudController;
use Illuminate\Support\Facades\Route;

Route::get('/', InicioController::class)->name('inicio');

Route::post('/solicitudes', [SolicitudController::class, 'store'])
    ->middleware('throttle:5,1') // máx. 5 envíos por minuto por IP
    ->name('solicitudes.store');
