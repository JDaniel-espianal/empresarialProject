<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\AsistenciaController;

// Ruta de bienvenida
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Dashboard principal
Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');

// Rutas de empleados
Route::resource('empleados', EmpleadoController::class);

// Rutas de departamentos
Route::resource('departamentos', DepartamentoController::class);

// Rutas de asistencia
Route::resource('asistencia', AsistenciaController::class);
Route::post('asistencia/marcar-entrada', [AsistenciaController::class, 'marcarEntrada'])->name('asistencia.marcar-entrada');
Route::post('asistencia/marcar-salida', [AsistenciaController::class, 'marcarSalida'])->name('asistencia.marcar-salida');

// Rutas temporales de vacaciones (simplificadas)
Route::get('vacaciones', function () { 
    return view('vacaciones.index'); 
})->name('vacaciones.index');

// Incluir rutas de autenticación de Breeze
require __DIR__.'/auth.php';