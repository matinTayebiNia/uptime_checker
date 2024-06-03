<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\user\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::get("/websites", [WebsiteController::class, "index"]);
Route::post("/websites/create", [WebsiteController::class, "index"]);

Route::post("/refresh", [AuthController::class, "refresh"])->name("refresh");
Route::post('/logout', [AuthController::class, 'logout'])->name("logout");
Route::get('/me', [AuthController::class, 'me'])->name("me");
