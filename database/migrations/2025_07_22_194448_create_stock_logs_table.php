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
        Schema::create('stock_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['manual_add', 'manual_subtract', 'rental_out', 'rental_return', 'maintenance', 'damaged']);
            $table->integer('quantity_before');
            $table->integer('quantity_after');
            $table->integer('quantity_changed');
            $table->text('reason')->nullable();
            $table->json('metadata')->nullable(); // For storing additional data like rental_id, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_logs');
    }
};
