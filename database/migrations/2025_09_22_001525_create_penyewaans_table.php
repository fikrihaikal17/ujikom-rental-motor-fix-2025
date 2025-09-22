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
        Schema::create('penyewaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyewa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('motor_id')->constrained('motors')->onDelete('cascade');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('tipe_durasi', ['harian', 'mingguan', 'bulanan']);
            $table->decimal('harga', 12, 2);
            $table->enum('status', ['pending', 'confirmed', 'active', 'completed', 'cancelled'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index(['motor_id', 'status']);
            $table->index(['penyewa_id', 'status']);
            $table->index(['tanggal_mulai', 'tanggal_selesai']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyewaans');
    }
};
