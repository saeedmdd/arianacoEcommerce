<?php

use App\Http\Controllers\Api\v1\ProductController;


Route::apiResource("/", ProductController::class)->parameter("","product");
Route::post("discount/store", [\App\Http\Controllers\Api\v1\DiscountController::class, 'store']);

