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
        Schema::create('savedprops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prop_id')->index(); 
            $table->unsignedBigInteger('user_id')->index(); 
            $table->string('title', 100);
            $table->string('image', 100);
            $table->string('location', 200)->index(); 
            $table->string('price', 100);
            $table->timestamps();
            
            
            $table->unique(['user_id', 'prop_id']);

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
        Schema::dropIfExists('savedprops');
    }
};