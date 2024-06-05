<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UptimeSettingRequest;
use App\Http\Resources\UptimeResource;
use App\Models\UptimeSetting;
use Exception;
use Illuminate\Http\JsonResponse;

class UptimeSettingController extends Controller
{
    public function index(): UptimeResource|JsonResponse
    {
        try {
            $setting = UptimeSetting::first();
            return UptimeResource::make($setting);
        } catch (Exception $exception) {
            return response()->json(["data" => "error"], 500);
        }
    }

    public function update(UptimeSettingRequest $request): UptimeResource|JsonResponse
    {
        try {
            $setting = UptimeSetting::first();

            $setting->update($request->validated());

            return UptimeResource::make($setting);

        } catch (Exception $exception) {
            return response()->json(["data" => "error"], 500);
        }
    }
}
