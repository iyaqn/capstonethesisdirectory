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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('action'); // e.g., "Created Project", "Deleted Document"
            $table->string('log_course')->nullable(); // e.g., "IT", "IS", "CS"
            $table->string('log_type')->nullable(); // e.g., "Admin", "Faculty", "Student"
            $table->timestamps(); // This will capture the created_at and updated_at (action time)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
