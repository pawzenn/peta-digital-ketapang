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
        Schema::table('wisatas', function (Blueprint $table) {
            $table->string('foto_rute')->nullable()->after('maps_link');
        });

        Schema::table('homestays', function (Blueprint $table) {
            $table->string('foto_rute')->nullable()->after('maps_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wisatas', function (Blueprint $table) {
            $table->dropColumn('foto_rute');
        });

        Schema::table('homestays', function (Blueprint $table) {
            $table->dropColumn('foto_rute');
        });
    }
};
