<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\HabitacionController;

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/hotels/create', [HotelController::class, 'create'])->name('hotels.create');
    Route::post('/hotels', [HotelController::class, 'store'])->name('hotels.store');
    Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
    Route::get('/hotels/{hotel}/edit', [HotelController::class, 'edit'])->name('hotels.edit');
    Route::put('/hotels/{hotel}', [HotelController::class, 'update'])->name('hotels.update');
    Route::get('/room-types', [RoomTypeController::class, 'index'])->name('roomTypes.index');
    Route::resource('hotels', HotelController::class);
    Route::post('hotels/{hotel}/add-room', [HotelController::class, 'addRoom'])->name('hotels.addRoom');
    Route::post('/rooms', [HabitacionController::class, 'store'])->name('rooms.store'); // Usando HabitacionController

});



















