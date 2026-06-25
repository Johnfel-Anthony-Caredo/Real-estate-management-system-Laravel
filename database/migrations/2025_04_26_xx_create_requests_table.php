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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prop_id')->index(); // Index already added by foreign key
            $table->string('agent_name', 100)->index(); // Add index for filtering by agent
            $table->unsignedBigInteger('user_id')->index(); // Index already added by foreign key
            $table->string('name', 100);
            $table->string('email', 100)->index(); // Add index for email searches
            $table->string('phone', 100);
            $table->enum('status', ['pending', 'completed'])->default('pending')->index(); // Add index for status filtering
            $table->timestamps();
            
            // Index for created_at for sorting by date
            $table->index('created_at');

            // Foreign key constraints
            $table->foreign('prop_id')
                  ->references('id')
                  ->on('props')
                  ->onDelete('cascade');
                  
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};