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
        Schema::create('bencana_kejadians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bencana_id')->constrained()->cascadeOnDelete();
            $table->string('judul', 150);
            $table->date('tanggal_kejadian');
            $table->string('lokasi', 255)->nullable();
            $table->text('uraian')->nullable();
            $table->unsignedInteger('korban_meninggal')->nullable();
            $table->unsignedInteger('korban_luka')->nullable();
            $table->unsignedInteger('warga_mengungsi')->nullable();
            $table->unsignedInteger('rumah_rusak')->nullable();
            $table->string('kerugian', 100)->nullable();
            $table->string('sumber', 150)->nullable();
            $table->timestamps();

            $table->index(['bencana_id', 'tanggal_kejadian']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bencana_kejadians');
    }
};
