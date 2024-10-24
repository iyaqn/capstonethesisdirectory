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
        
        Schema::create('projects', function (Blueprint $table) {
            $table->timestamps();
            $table->id();
            $table->string('ipRegistration')->nullable();
            $table->string(column: 'specialization')->nullable();
            $table->string('title')->nullable();
            $table->string(column: 'author1')->nullable();  
            $table->string(column: 'author2')->nullable();
            $table->string(column: 'author3')->nullable();
            $table->string(column: 'author4')->nullable();
            $table->string('technicalAdviser')->nullable();
            $table->string('yearPublished')->nullable();
            $table->string('fullDocument')->nullable();
            $table->string('acmPaper')->nullable();
            $table->string('sourceCode')->nullable();
            $table->string('approvalForm')->nullable();
            $table->string('keywords')->nullable();

            $table->string(column: 'course')->nullable();
            $table->string(column: 'pub_mat')->nullable();
            $table->boolean('is_best_proj')->default('0');
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
