<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/register", [AuthController::class, "register"])->name("register");
Route::post("/login", [AuthController::class, "login"])->name("login");

Route::middleware('auth:api')->group(function () {
    Route::post("/refresh", [AuthController::class, "refresh"])->name("refresh");
    Route::post('/logout', [AuthController::class, 'logout'])->name("logout");
    Route::get('/me', [AuthController::class, 'me'])->name("me");
});
//
