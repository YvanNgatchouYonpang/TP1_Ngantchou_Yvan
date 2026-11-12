
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;

Route::get('/equipment', [EquipmentController::class, 'index']);
Route::get('/users/{userId}/rentals', [RentalController::class, 'index']);
Route::get('/equipment/{id}/popularity', [EquipmentController::class, 'popularity']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);
Route::get('/equipment/{id}/average-rental-price', [EquipmentController::class, 'averageRentalPrice']);
