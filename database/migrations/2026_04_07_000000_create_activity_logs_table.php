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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('action'); // 'created', 'updated', 'deleted'
            $table->json('old_values')->nullable(); // Previous data before update
            $table->json('new_values')->nullable(); // New data after update
            $table->text('changes_summary')->nullable(); // Human readable summary of changes
            $table->timestamps();
            
            // Index for faster filtering
            $table->index('student_id');
            $table->index('action');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
