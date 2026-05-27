<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations - SKIPPED (password now in main table)
     */
    public function up(): void
    {
        // This migration is now obsolete as password is included in the main user_accounts table
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No action needed
    }
};
