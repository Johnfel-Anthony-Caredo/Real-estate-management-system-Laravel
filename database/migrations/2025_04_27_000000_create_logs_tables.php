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
      
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->index(); 
            $table->string('operation', 10)->index(); 
            $table->text('changed_data');
            $table->timestamp('performed_at')->useCurrent()->index(); 
        });

        // Create prop_logs table
        Schema::create('prop_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prop_id')->index(); 
            $table->string('operation', 10)->index(); 
            $table->text('changed_data');
            $table->timestamp('performed_at')->useCurrent()->index(); 
        });

        // Create user_logs table
        Schema::create('user_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); 
            $table->string('operation', 10)->index(); 
            $table->text('changed_data');
            $table->timestamp('performed_at')->useCurrent()->index(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_logs');
        Schema::dropIfExists('prop_logs');
        Schema::dropIfExists('user_logs');
    }
};