<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kategori_umkm_id')
                ->constrained('kategori_umkms')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

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

    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
