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
        Schema::create('mc_checks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('external_id', 255)->nullable();
            $table->string('dispatcher_name', 250)->nullable();
            $table->string('carrier_name', 255)->nullable();
            $table->string('carrier_dot', 255)->nullable();
            $table->string('carrier_mc_ff_input', 255)->nullable();
            $table->string('carrier_email', 255)->nullable();
            $table->string('carrier_telephone', 255)->nullable();
            $table->string('carrier_commodity_type', 255)->nullable();
            $table->string('carrier_commodity_name', 255)->nullable();
            $table->string('carrier_commodity_value', 255)->nullable();
            $table->string('carrier_equipment_type', 255)->nullable();
            $table->string('carrier_mc_purpose', 255)->nullable();
            $table->string('carrier_commodity_value_proof', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mc_checks');
    }
};
