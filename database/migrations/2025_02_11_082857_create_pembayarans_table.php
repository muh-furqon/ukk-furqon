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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->enum('metode', ['tunai', 'transfer']);
            $table->enum('status', ['belum dibayar', 'sudah dibayar']);
            $table->bigInteger('total_bayar'); // <-- How much the customer paid
            $table->bigInteger('kembalian')->default(0); // <-- Change to return (if cash)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
