<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kamar_id')->constrained('kamar')->onDelete('cascade');
            $table->date('tanggal_checkin');
            $table->date('tanggal_checkout');
            $table->integer('jumlah_tamu');
            $table->enum('metode_pembayaran', ['Bank Transfer', 'QRIS']);
            $table->string('bukti_pembayaran')->nullable(); // path ke gambar
            $table->enum('status', ['Menunggu Konfirmasi', 'Dikonfirmasi', 'Dibatalkan'])->default('Menunggu Konfirmasi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
