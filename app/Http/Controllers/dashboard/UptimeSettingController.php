<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UptimeSettingRequest;
use App\Http\Resources\UptimeResource;
use App\Models\UptimeSetting;

class UptimeSettingController extends Controller
{
    public function index()
    {
        try {
            $setting = UptimeSetting::first();
            return UptimeResource::make($setting);
        } catch (\Exception $exception) {
            return response()->json(["data" => "error"], 500);
        }
    }

    public function update(UptimeSettingRequest $request)
    {
        try {
            $setting = UptimeSetting::first();

            $setting->update($request->validated());

            return UptimeResource::make($setting);

        } catch (\Exception $exception) {
            response()->json(["data" => "error"], 500);
        }
    }
}
