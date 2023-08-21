<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\TipoHabitacionController;
use App\Http\Controllers\HabitacionController;

Route::group(['prefix' => 'hoteles'], function () {
    Route::get('/', [HotelController::class, 'index']);
    Route::post('/', [HotelController::class, 'store']);
    Route::get('/{id}', [HotelController::class, 'show']);
    Route::put('/{id}', [HotelController::class, 'update']);
    Route::delete('/{id}', [HotelController::class, 'destroy']);
});

Route::group(['prefix' => 'tipos-habitacion'], function () {
    Route::get('/', [TipoHabitacionController::class, 'index']);
    Route::post('/', [TipoHabitacionController::class, 'store']);
    Route::get('/{id}', [TipoHabitacionController::class, 'show']);
    Route::put('/{id}', [TipoHabitacionController::class, 'update']);
    Route::delete('/{id}', [TipoHabitacionController::class, 'destroy']);
});

Route::group(['prefix' => 'habitaciones'], function () {
    Route::get('/', [HabitacionController::class, 'index']);
    Route::post('/', [HabitacionController::class, 'store']);
    Route::get('/{id}', [HabitacionController::class, 'show']);
    Route::put('/{id}', [HabitacionController::class, 'update']);
    Route::delete('/{id}', [HabitacionController::class, 'destroy']);
});
