<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/auth')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('auth.login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/companies', CompanyController::class);
    Route::apiResource('/employees', EmployeeController::class);
});
