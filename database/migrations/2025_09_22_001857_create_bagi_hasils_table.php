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
        Schema::create('bagi_hasils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyewaan_id')->constrained('penyewaans')->onDelete('cascade');
            $table->foreignId('pemilik_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_pendapatan', 12, 2);
            $table->decimal('bagi_hasil_pemilik', 12, 2); // 70%
            $table->decimal('bagi_hasil_admin', 12, 2);   // 30%
            $table->date('tanggal');
            $table->timestamp('settled_at')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index('penyewaan_id');
            $table->index('pemilik_id');
            $table->index(['tanggal', 'settled_at']);
            $table->unique('penyewaan_id'); // One revenue share per booking
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bagi_hasils');
    }
};
