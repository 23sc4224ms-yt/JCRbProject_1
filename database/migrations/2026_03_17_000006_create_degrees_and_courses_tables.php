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
        Schema::create('degrees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('degree_id')->constrained('degrees')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('degree_id')->nullable()->constrained('degrees')->onDelete('set null');
            $table->dropColumn('course');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['degree_id']);
            $table->dropColumn('degree_id');
            $table->string('course');
        });

        Schema::dropIfExists('courses');
        Schema::dropIfExists('degrees');
    }
};
