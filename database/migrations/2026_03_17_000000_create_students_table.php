<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * - Tinatawag ng: php artisan migrate
     * - Ginagawa nito: Nagcre-create ng "students" table sa database
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();                   // Auto-increment primary key (id)
            $table->string('name');         // VARCHAR column para sa pangalan
            $table->integer('contact')->nullable();     // INTEGER column para sa contact number
            $table->integer('age');         // INTEGER column para sa edad
            $table->string('course');       // VARCHAR column para sa kurso
            $table->timestamps();           // created_at at updated_at columns (auto)
        });
    }

    /**
     * Reverse the migrations.
     * - Tinatawag ng: php artisan migrate:rollback
     * - Ginagawa nito: Binubura ang "students" table
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
