<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboard\UptimeSettingController;
use App\Http\Controllers\dashboard\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::apiResource("websites", WebsiteController::class);

Route::get("/setting",[UptimeSettingController::class,"index"]);
Route::put("/setting/update",[UptimeSettingController::class,"update"]);

Route::post("/refresh", [AuthController::class, "refresh"])->name("refresh");
Route::post('/logout', [AuthController::class, 'logout'])->name("logout");
Route::get('/me', [AuthController::class, 'me'])->name("me");
