<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/students', [StudentController::class, 'dex']);
Route::post('/students', [StudentController::class, 'stoe']);
Route::get('/students/{id}', [StudentController::class, 'sho']);
Route::patch('/students/{id}', [StudentController::class, 'up']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
