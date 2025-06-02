<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('pkl', App\Http\Controllers\Api\PklController::class);
Route::apiResource('student', App\Http\Controllers\Api\StudentController::class);
Route::apiResource('teacher', App\Http\Controllers\Api\TeacherController::class);
Route::apiResource('industry', App\Http\Controllers\Api\IndustryController::class);