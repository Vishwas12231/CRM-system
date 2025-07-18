<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LeadController;
use Illuminate\Support\Facades\Route;




Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('leads', LeadController::class);
    Route::post('/leads/{lead}/assign', [LeadController::class, 'assign']);
});
