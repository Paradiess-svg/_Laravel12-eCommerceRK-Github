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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('kode_admin')->nullable(); // K001
        // Relasi ke cabang (nullable karena owner bisa akses semua)
        $table->foreignId('id_cabang')->nullable()->constrained('cabangs')->nullOnDelete();
        $table->string('name'); // nama
        $table->string('email')->unique();
        $table->enum('jk', ['L', 'P'])->nullable(); // Jenis Kelamin
        $table->string('password');
        $table->string('jabatan')->nullable();
        $table->string('no_telfon')->nullable();
        // Role: admin, super_admin, owner
        $table->enum('role', ['admin', 'super_admin', 'owner'])->default('admin');
        $table->text('alamat')->nullable();
        $table->string('foto')->nullable();
        $table->rememberToken();
        $table->timestamps();
    });
    
    // ... biarkan kode sessions di bawahnya ...
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
