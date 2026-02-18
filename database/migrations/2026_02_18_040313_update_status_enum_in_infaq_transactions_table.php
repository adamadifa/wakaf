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
        // Using raw SQL to avoid doctrine/dbal dependency for enum modification
        DB::statement("ALTER TABLE infaq_transactions MODIFY COLUMN status ENUM('pending', 'confirmed', 'rejected', 'cancelled') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE infaq_transactions MODIFY COLUMN status ENUM('pending', 'confirmed', 'rejected') DEFAULT 'pending'");
    }
};
