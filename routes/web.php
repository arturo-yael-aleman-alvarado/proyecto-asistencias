<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\AsistenciaController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/asistencias/marcar', [AsistenciaController::class, 'marcar'])->name('asistencia.marcar');

Route::middleware('auth')->group(function () {
    // Rutas para Asistencias
    Route::get('/asistencias', [AsistenciaController::class, 'index'])->name('asistencias.index');

    // Rutas para Empleados
    Route::resource('empleados', EmpleadoController::class);  // Esto maneja todas las rutas para empleados
});

// Ruta para el logout (si la estás usando en el navbar)
Route::post('/logout', [Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

require __DIR__.'/auth.php';
