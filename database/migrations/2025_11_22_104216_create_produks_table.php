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
    Schema::create('produks', function (Blueprint $table) {
        $table->id();
        $table->string('kode_produk');
        $table->foreignId('id_cabang')->constrained('cabangs')->cascadeOnDelete();
        $table->foreignId('id_kategori')->constrained('kategoris')->cascadeOnDelete();
        $table->string('nama');
        $table->text('deskripsi')->nullable(); // atau 'desk' sesuaikan dgn model kamu
        $table->integer('harga');
        $table->integer('stok');
        
        // === TAMBAHKAN BARIS INI ===
        $table->string('foto')->nullable(); 
        // ===========================

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
