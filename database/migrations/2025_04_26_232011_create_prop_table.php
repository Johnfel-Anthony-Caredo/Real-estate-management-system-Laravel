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
        Schema::create('props', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200)->nullable()->index();
            $table->string('price', 50)->nullable()->index();
            $table->string('image', 200)->nullable();
            $table->string('beds', 50)->nullable()->index();
            $table->string('baths', 50)->nullable()->index(); 
            $table->string('sq_ft', 50)->nullable();
            $table->string('home_type', 200)->nullable()->index(); 
            $table->string('year_built', 200)->nullable();
            $table->string('price_sqft', 50)->nullable();
            $table->text('more_info')->nullable();
            $table->string('location', 200)->nullable();
            $table->string('agent_name', 100)->nullable()->index(); 
            $table->timestamps(); 
            
            
            $table->foreign('home_type')
                  ->references('hometypes')
                  ->on('hometypes')
                  ->onDelete('cascade'); 
            
            $table->index(['beds', 'baths', 'price']);
            
            
            $table->fullText('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('props');
    }
};