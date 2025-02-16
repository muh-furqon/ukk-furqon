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
        Schema::create('penjualan_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penjualan_id')->nullable(); // Nullable for safety
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->integer('jumlah_jual');
            $table->bigInteger('sub_total');
            $table->timestamps();
        
            $table->foreign('penjualan_id')->references('id')->on('penjualans')->onDelete('set null');
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('set null');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_details');
    }
};
