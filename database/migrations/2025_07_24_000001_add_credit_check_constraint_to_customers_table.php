<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Defense-in-depth: Add a CHECK constraint to prevent remaining_credit
     * from going negative at the database level. Even if application logic
     * has a bug, the DB will reject the write.
     *
     * NOTE: MySQL 8.0.16+ supports CHECK constraints. For older versions,
     * this migration will silently succeed but the constraint won't be enforced.
     */
    public function up(): void
    {
        // Add CHECK constraint to prevent negative remaining_credit
        try {
            DB::statement('ALTER TABLE customers ADD CONSTRAINT chk_remaining_credit_non_negative CHECK (remaining_credit >= 0)');
        } catch (\Exception $e) {
            // Silently skip if the constraint already exists or DB doesn't support CHECK
            \Log::warning('Could not add CHECK constraint on remaining_credit: ' . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement('ALTER TABLE customers DROP CONSTRAINT chk_remaining_credit_non_negative');
        } catch (\Exception $e) {
            // Silently skip if constraint doesn't exist
        }
    }
};
