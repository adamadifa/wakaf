<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('zakat_transactions', function (Blueprint $table) {
            $table->string('snap_token')->nullable()->after('payment_proof');
            $table->foreignId('payment_method_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('zakat_transactions', function (Blueprint $table) {
            $table->dropColumn('snap_token');
            $table->foreignId('payment_method_id')->nullable(false)->change();
        });
    }
};
