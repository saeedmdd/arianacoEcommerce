<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;

Route::post("login", [AuthController::class, "login"]);

Route::post("register", [AuthController::class, "register"]);
