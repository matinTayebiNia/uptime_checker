<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('uptime_settings', function (Blueprint $table) {
            $table->id();
            $table->string("app_name")->nullable();
            $table->integer("check_per_minute")->nullable();
            $table->enum("notification_type", ["email", "sms"])->default("email");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uptime_settings');
    }
};
