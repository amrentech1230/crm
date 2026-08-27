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
        Schema::create('shippers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('consignee_id')->nullable();
            $table->string('shipper_name', 255)->nullable();
            $table->string('shipper_address', 255)->nullable();
            $table->string('shipper_country', 255)->nullable();
            $table->string('shipper_state', 255)->nullable();
            $table->string('shipper_city', 255)->nullable();
            $table->string('shipper_zip', 255)->nullable();
            $table->string('shipper_contact_name', 255)->nullable();
            $table->string('shipper_contact_email', 255)->nullable();
            $table->string('shipper_telephone', 255)->nullable();
            $table->string('shipper_extn', 255)->nullable();
            $table->string('shipper_toll_free', 255)->nullable();
            $table->string('shipper_fax', 255)->nullable();
            $table->string('shipper_hours', 255)->nullable();
            $table->string('shipper_appointments', 255)->nullable();
            $table->string('shipper_major_intersections', 255)->nullable();
            $table->string('shipper_status', 255)->nullable();
            $table->longText('shipper_shipping_notes')->nullable();
            $table->longText('shipper_internal_notes')->nullable();
            $table->string('commenter_name', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippers');
    }
};
