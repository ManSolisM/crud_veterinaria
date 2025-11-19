<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\VacunaController;
use Illuminate\Support\Facades\Route;

// Ruta para crear admin
Route::get('/crear-admin', [AuthController::class, 'crearAdmin'])->name('crear.admin');

// Rutas públicas
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
});

// Rutas protegidas
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Usuarios
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/', [UsuarioController::class, 'index'])->name('index');
        Route::post('/', [UsuarioController::class, 'store'])->name('store');
        Route::put('/{id}', [UsuarioController::class, 'update'])->name('update');
        Route::delete('/{id}', [UsuarioController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [UsuarioController::class, 'restore'])->name('restore');
        Route::post('/{id}/toggle-activo', [UsuarioController::class, 'toggleActivo'])->name('toggle-activo');
    });
    
    // Citas
    Route::prefix('citas')->name('citas.')->group(function () {
        Route::get('/', [CitaController::class, 'index'])->name('index');
        Route::post('/', [CitaController::class, 'store'])->name('store');
        Route::put('/{id}', [CitaController::class, 'update'])->name('update');
        Route::delete('/{id}', [CitaController::class, 'destroy'])->name('destroy');
    });
    
});