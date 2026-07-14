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
        Schema::create('bencanas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('slug', 170)->unique();
            $table->string('jenis_bencana', 40);
            $table->string('tingkat_risiko', 20);
            $table->text('deskripsi');
            $table->string('cover_foto')->nullable();
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
        Schema::dropIfExists('bencanas');
    }
};
