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
        Schema::create('externals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('dispatcher_name', 255)->nullable();
            $table->string('carrier_name', 255)->nullable();
            $table->string('carrier_dot', 255)->nullable();
            $table->string('carrier_mc_ff', 255)->nullable();
            $table->string('carrier_mc_ff_input', 255)->nullable();
            $table->string('carrier_address', 255)->nullable();
            $table->string('carrier_address_two', 255)->nullable();
            $table->string('carrier_country', 255)->nullable();
            $table->string('carrier_address_three', 255)->nullable();
            $table->string('carrier_state', 255)->nullable();
            $table->string('carrier_city', 255)->nullable();
            $table->string('carrier_zip', 255)->nullable();
            $table->string('carrier_contact_name', 255)->nullable();
            $table->string('carrier_email', 255)->nullable();
            $table->string('carrier_telephone', 255)->nullable();
            $table->string('carrier_extn', 255)->nullable();
            $table->string('carrier_tollfree', 255)->nullable();
            $table->string('carrier_fax', 255)->nullable();
            $table->string('carrier_payment_terms', 255)->nullable();
            $table->string('carrier_tax_id', 255)->nullable();
            $table->string('carrier_username', 255)->nullable();
            $table->string('carrier_password', 255)->nullable();
            $table->string('carrier_factoring_company', 255)->nullable();
            $table->longText('carrier_notes')->nullable();
            $table->string('carrier_status', 255)->nullable();
            $table->string('carrier_load_type', 255)->nullable();
            $table->string('carrier_blacklisted', 255)->nullable();
            $table->string('carrier_corporation', 255)->nullable();
            $table->longText('carrier_file_upload')->nullable();
            $table->string('mc_check', 250)->nullable();
            $table->string('commodity_type', 255)->nullable();
            $table->string('commodity_name', 255)->nullable();
            $table->string('commodity_value', 255)->nullable();
            $table->string('equipment_type', 255)->nullable();
            $table->string('mc_purpose', 255)->nullable();
            $table->string('commodity_file', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('externals');
    }
};
