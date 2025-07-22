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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->text('deskripsi')->nullable();
            $table->string('kategori');
            $table->integer('stok');
            $table->integer('stok_minimum')->default(5);
            $table->string('kondisi')->default('baik'); // baik, rusak, maintenance
            $table->string('lokasi_penyimpanan')->nullable();
            $table->decimal('harga_sewa_per_hari', 10, 2)->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['tersedia', 'tidak_tersedia', 'maintenance'])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
