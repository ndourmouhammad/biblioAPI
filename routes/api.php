<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("login", [ApiController::class, "login"]);

Route::middleware("auth")->group(function () {

    Route::get("logout", [ApiController::class, "logout"]);
    Route::get("refresh", [ApiController::class, "refreshToken"]);
});
