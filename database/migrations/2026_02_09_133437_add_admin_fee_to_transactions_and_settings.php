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
        // Add midtrans_admin_fee to settings
        Schema::table('settings', function (Blueprint $table) {
            $table->decimal('midtrans_admin_fee', 10, 2)->default(0)->after('midtrans_is_production');
        });

        // Add admin_fee to zakat_transactions
        Schema::table('zakat_transactions', function (Blueprint $table) {
            $table->decimal('admin_fee', 10, 2)->default(0)->after('amount');
        });

        // Add admin_fee to donations
        Schema::table('donations', function (Blueprint $table) {
            $table->decimal('admin_fee', 10, 2)->default(0)->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('midtrans_admin_fee');
        });

        Schema::table('zakat_transactions', function (Blueprint $table) {
            $table->dropColumn('admin_fee');
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn('admin_fee');
        });
    }
};
