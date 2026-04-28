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
    Schema::create('rakit_pcs', function (Blueprint $table) {
        $table->id();
        $table->string('kode_rakitan')->unique(); // RK321
        $table->string('processor')->nullable();
        $table->string('motherboard')->nullable();
        $table->string('ram')->nullable();
        $table->string('casing')->nullable();
        $table->string('ssd')->nullable();
        $table->string('hdd')->nullable();
        $table->string('vga')->nullable();
        $table->string('psu')->nullable();
        $table->string('mouse')->nullable();
        $table->string('keyboard')->nullable();
        $table->string('monitor')->nullable();
        $table->string('coolerfan')->nullable();
        $table->bigInteger('total_harga')->default(0); // Tambahan biar enak liat total
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rakit_pcs');
    }
};
