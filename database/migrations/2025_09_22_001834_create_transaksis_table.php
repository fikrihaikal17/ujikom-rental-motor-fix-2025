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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyewaan_id')->constrained('penyewaans')->onDelete('cascade');
            $table->string('kode_transaksi', 50)->unique();
            $table->decimal('jumlah', 12, 2);
            $table->enum('metode_pembayaran', ['transfer', 'cash', 'midtrans_snap', 'qris']);
            $table->enum('status', ['pending', 'paid', 'failed', 'cancelled'])->default('pending');
            $table->json('payment_details')->nullable(); // Store Midtrans response, etc.
            $table->timestamp('paid_at')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index('penyewaan_id');
            $table->index(['status', 'metode_pembayaran']);
            $table->index('kode_transaksi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
