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
            CREATE VIEW requests_view AS
            SELECT 
                r.id,
                r.prop_id,
                r.user_id,
                r.name,
                r.email,
                r.phone,
                r.agent_name,
                r.created_at,
                r.status,
                p.title as property_title,
                p.price as property_price,
                p.location as property_location,
                p.image as property_image
            FROM requests r
            JOIN props p ON r.prop_id = p.id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS requests_view");
    }
};