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
        Schema::table('motors', function (Blueprint $table) {
            $table->string('model', 50)->nullable()->after('merk');
            $table->year('tahun')->nullable()->after('model');
            $table->string('warna', 30)->nullable()->after('no_plat');
            $table->text('deskripsi')->nullable()->after('warna');
            $table->enum('ketersediaan', ['tersedia', 'tidak_tersedia'])->default('tersedia')->after('status');
            $table->text('admin_notes')->nullable()->after('dokumen_kepemilikan');
            $table->timestamp('verified_at')->nullable()->after('admin_notes');
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete()->after('verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('motors', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn([
                'model',
                'tahun',
                'warna',
                'deskripsi',
                'ketersediaan',
                'admin_notes',
                'verified_at',
                'verified_by'
            ]);
        });
    }
};
