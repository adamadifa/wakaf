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
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->timestamps();
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->foreignId('donor_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
        });

        // Migrate existing donors from users table
        $donors = \Illuminate\Support\Facades\DB::table('users')->where('role', 'donor')->get();
        
        foreach ($donors as $user) {
            // Create donor
            $donorId = \Illuminate\Support\Facades\DB::table('donors')->insertGetId([
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]);

            // Update donations
            \Illuminate\Support\Facades\DB::table('donations')
                ->where('user_id', $user->id)
                ->update(['donor_id' => $donorId]);
            
            // Note: We are NOT deleting the users automatically for safety, 
            // but in a real scenario we might want to cleanup. 
            // For now, let's keep them but maybe just update the donations is enough.
        }
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['donor_id']);
            $table->dropColumn('donor_id');
        });

        Schema::dropIfExists('donors');
    }
};
