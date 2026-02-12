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
        Schema::create('wisatas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('slug', 170)->unique();
            $table->text('deskripsi');
            $table->unsignedTinyInteger('rating')->nullable(); // 1-5
            $table->string('cover_foto')->nullable();          // path jpg
            $table->string('alamat', 255)->nullable();
            $table->text('maps_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wisatas');
    }
};
