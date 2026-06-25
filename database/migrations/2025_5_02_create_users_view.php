<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW users_view AS
            SELECT 
                id,
                name,
                email,
                email_verified_at,
                created_at,
                updated_at
            FROM users
        ");
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS user_logs_view");
        DB::statement("DROP VIEW IF EXISTS users_view");
    }
};