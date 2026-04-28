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
    Schema::create('heroes', function (Blueprint $table) {
        $table->id();
        $table->string('kode_hero')->nullable();
        $table->string('judul');
        $table->string('foto');
        $table->text('deskripsi')->nullable();
        $table->string('link')->default('#');
        // status: aktif, nonaktif, promo, laris
        $table->enum('status', ['aktif', 'nonaktif', 'promo', 'laris'])->default('nonaktif');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heroes');
    }
};
