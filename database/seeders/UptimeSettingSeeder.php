<?php

namespace Database\Seeders;

use App\Models\UptimeSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UptimeSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UptimeSetting::create([
            "app_name"=>"uptime checker",
            "check_per_minute"=>100,
        ]);
    }
}
