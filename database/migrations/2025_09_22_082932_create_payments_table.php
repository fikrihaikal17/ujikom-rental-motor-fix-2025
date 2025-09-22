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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyewaan_id')->constrained('penyewaans')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['transfer', 'cash']);
            $table->string('bukti_transfer')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['pending', 'completed', 'rejected'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
