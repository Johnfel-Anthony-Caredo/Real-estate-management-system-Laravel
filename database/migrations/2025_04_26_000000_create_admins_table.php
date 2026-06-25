<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->index(); 
            $table->string('email', 100)->unique(); 
            $table->string('password', 100);
            $table->timestamps();
            
         
            $table->index('created_at');
        });

       
        DB::statement("
            CREATE OR REPLACE VIEW admins_view AS
            SELECT 
                id,
                name,
                email,
                created_at,
                updated_at
            FROM admins
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS admins_view");
        Schema::dropIfExists('admins');
    }
};