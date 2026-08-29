<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('profils', function (Blueprint $table) {
            $table->string('instagram_nama')->nullable();
            $table->string('facebook_nama')->nullable();
            $table->string('tiktok_nama')->nullable();
            $table->string('youtube_nama')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profils', function (Blueprint $table) {
            $table->dropColumn(['instagram_nama', 'facebook_nama', 'tiktok_nama', 'youtube_nama']);
        });
    }
};
