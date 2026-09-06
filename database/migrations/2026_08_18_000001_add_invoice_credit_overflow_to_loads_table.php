<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Records how much of this load was charged to the customer's invoicing limit
     * because the remaining limit could not cover it. Needed so cancelling the load
     * returns the credit to the same limits it was taken from.
     */
    public function up(): void
    {
        Schema::table('loads', function (Blueprint $table) {
            $table->decimal('invoice_credit_overflow', 15, 2)->default(0)->after('shipper_load_final_rate');
        });
    }

    public function down(): void
    {
        Schema::table('loads', function (Blueprint $table) {
            $table->dropColumn('invoice_credit_overflow');
        });
    }
};
