<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MovementController;

Route::middleware('guest')->group(function () {

    Route::get('/', function () {

        if (auth()->check()) {
            return redirect('/finance');
        }

        return view('auth.login');

    })->name('show-login-form');

    Route::get('/login', function () {
        return redirect()->route('show-login-form');
    });

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login');
});


Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');
    Route::get('/api/user', function () {
        return response()->json(auth()->user());
    })->middleware('auth');


    // API para Vue
    Route::get('/api/movements', [MovementController::class, 'index']);

    // INVENTARIO DE EQUIPOS
    Route::controller(\App\Http\Controllers\EquipmentController::class)->prefix('equipment')->group(function () {

        Route::get('/', 'index');
        Route::post('/add', 'add');
        Route::get('/{equipment}', 'show');
        Route::post('/update', 'update');
        Route::delete('/delete/{equipment}', 'destroy');

    });


    // Entrada de Vue
    // Entrada de Vue
    Route::get('/{any}', function () {
        return view('app');
    })->where('any', '.*');
});
