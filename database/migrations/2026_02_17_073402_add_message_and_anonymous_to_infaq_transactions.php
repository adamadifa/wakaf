<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('infaq_transactions', function (Blueprint $table) {
            $table->boolean('is_anonymous')->default(false)->after('phone');
            $table->text('message')->nullable()->after('is_anonymous');
            $table->integer('unique_code')->default(0)->after('admin_fee');
        });
    }

    public function down(): void
    {
        Schema::table('infaq_transactions', function (Blueprint $table) {
            $table->dropColumn(['is_anonymous', 'message', 'unique_code']);
        });
    }
};
