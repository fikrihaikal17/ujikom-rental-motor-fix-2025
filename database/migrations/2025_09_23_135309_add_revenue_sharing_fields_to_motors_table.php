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
            $table->decimal('owner_percentage', 5, 2)->default(70.00)->after('verified_by');
            $table->decimal('admin_percentage', 5, 2)->default(30.00)->after('owner_percentage');
            $table->decimal('requested_owner_percentage', 5, 2)->nullable()->after('admin_percentage');
            $table->text('revenue_sharing_notes')->nullable()->after('requested_owner_percentage');
            $table->boolean('revenue_sharing_approved')->default(false)->after('revenue_sharing_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('motors', function (Blueprint $table) {
            $table->dropColumn([
                'owner_percentage',
                'admin_percentage',
                'requested_owner_percentage',
                'revenue_sharing_notes',
                'revenue_sharing_approved'
            ]);
        });
    }
};
