<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penghargaans', function (Blueprint $table) {
            $table->id();
            $table->morphs('penghargaanable');
            $table->string('nama', 150);
            $table->string('tahun', 4)->nullable();
            $table->string('pemberi', 150)->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penghargaans');
    }
};
