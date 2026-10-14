<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ObraController;
use App\Http\Controllers\Admin\ServicioController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\SolicitudController;
use Illuminate\Support\Facades\Route;

Route::get('/', InicioController::class)->name('inicio');

Route::post('/solicitudes', [SolicitudController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('solicitudes.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AuthController::class, 'portal'])->name('home');
    Route::post('/', [AuthController::class, 'store'])->name('login');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('logout', [AuthController::class, 'destroy'])->name('logout');
        Route::resource('servicios', ServicioController::class)->except(['show']);
        Route::resource('obras', ObraController::class)->except(['show']);
    });
});
