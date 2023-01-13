<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\CartController;

Route::post("add", [CartController::class, "add"]);
Route::get("submitted", [CartController::class, "getSubmitted"]);
Route::post("submit", [CartController::class, "submit"]);
Route::apiResource("/", CartController::class)->parameter("", "cart")->only("show", "destroy", "update", "index");

