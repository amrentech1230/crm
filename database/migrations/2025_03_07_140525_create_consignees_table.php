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
        Schema::create('consignees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // User ID, foreign key reference (bigint)
            $table->string('consignee_name', 255)->nullable(); // Consignee name
            $table->string('consignee_address', 255)->nullable(); // Consignee address
            $table->string('consignee_country', 255)->nullable(); // Consignee country
            $table->string('consignee_state', 255)->nullable(); // Consignee state
            $table->string('consignee_city', 255)->nullable(); // Consignee city
            $table->string('consignee_zip', 255)->nullable(); // Consignee zip code
            $table->string('consignee_contact_name', 255)->nullable(); // Consignee contact name
            $table->string('consignee_contact_email', 255)->nullable(); // Consignee contact email
            $table->string('consignee_telephone', 255)->nullable(); // Consignee telephone
            $table->string('consignee_ext', 255)->nullable(); // Consignee extension
            $table->string('consignee_toll_free', 255)->nullable(); // Consignee toll-free number
            $table->string('consignee_fax', 255)->nullable(); // Consignee fax
            $table->string('consignee_hours', 255)->nullable(); // Consignee working hours
            $table->string('consignee_appointments', 255)->nullable(); // Consignee appointments
            $table->string('consignee_major_intersections', 255)->nullable(); // Consignee major intersections
            $table->string('consignee_status', 255)->nullable(); // Consignee status (active, inactive)
            $table->longText('consignee_internal_notes')->nullable(); // Internal notes about consignee
            $table->longText('consignee_shipping_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consignees');
    }
};
