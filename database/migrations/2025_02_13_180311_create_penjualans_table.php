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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi', 50)->unique()->nullable(); // Unique transaction code
            $table->unsignedBigInteger('member_id')->nullable(); // Nullable for non-members
            $table->unsignedBigInteger('pembayaran_id')->nullable(); // Nullable for unpaid transactions
            $table->dateTime('waktu'); // Transaction time
            $table->bigInteger('total'); // Total price
            $table->enum('status', ['belum dibayar', 'sudah dibayar', 'dibatalkan'])->default('belum dibayar'); // No online status
            $table->timestamps();
        
            $table->foreign('member_id')->references('id')->on('members')->onDelete('set null');
            $table->foreign('pembayaran_id')->references('id')->on('pembayarans')->onDelete('set null');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
