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
            $table->string('ipRegistration');
            $table->string(column: 'specialization');
            $table->string('title');
            $table->json('authors');
            $table->string('technicalAdviser');
            $table->string('yearPublished');
            $table->string('fullDocument');
            $table->string('acmPaper');
            $table->string('sourceCode');
            $table->string('approvalForm');
            $table->string('keywords');
            $table->string(column: 'tags');
            $table->string(column: 'course');
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
