<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\PaymentController;

Route::apiResource('students', StudentController::class);
Route::apiResource('payments', PaymentController::class);