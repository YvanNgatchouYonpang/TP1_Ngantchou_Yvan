
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\UserController;

Route::get('/equipment', [EquipmentController::class, 'index']);
Route::get('/users/{userId}/rentals', [RentalController::class, 'index']);
Route::get('/equipment/{id}/popularity', [EquipmentController::class, 'popularity']);
Route::post('/users', [UserController::class, 'store']);
