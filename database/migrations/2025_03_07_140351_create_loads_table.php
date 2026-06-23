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
        Schema::create('loads', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable(false);
            $table->longText('customer_id')->nullable();
            $table->integer('carrier_id')->nullable();
            $table->string('load_carrier', 255)->nullable();
            $table->string('load_number', 255)->nullable();
            $table->string('load_dispatcher', 255);
            $table->string('load_bill_to', 255)->nullable();
            $table->string('load_status', 255)->nullable();
            $table->string('load_workorder', 255)->nullable();
            $table->string('load_payment_type', 255)->nullable();
            $table->string('load_type', 255)->nullable();
            $table->string('load_pds', 255)->nullable();
            $table->string('load_fsc_rate', 255)->nullable();
            $table->string('load_telephone', 255)->nullable();
            $table->longText('carrier_load_other_charge')->nullable();
            $table->longText('shipper_load_other_charge')->nullable();
            $table->string('load_final_rate', 255)->nullable();
            $table->longText('carrier_dot')->nullable();
            $table->string('load_carrier_phone', 30)->nullable();
            $table->string('load_advance_payment', 255)->nullable();
            $table->string('load_type_two', 255)->nullable();
            $table->string('load_billing_type', 255)->nullable();
            $table->string('load_mc_no', 255)->nullable();
            $table->string('load_equipment_type', 255)->nullable();
            $table->string('load_currency', 255)->nullable();
            $table->string('load_pds_two', 255)->nullable();
            $table->string('load_billing_fsc_rate', 255)->nullable();
            $table->string('load_other_charge', 255)->nullable();
            $table->string('load_carrier_fee', 255)->nullable();
            $table->string('load_final_carrier_fee', 255)->nullable();
            $table->string('load_other_charge_two', 255)->nullable();
            $table->string('load_delivery_do_file', 1000)->nullable();
            $table->string('load_rate_coin_file', 1000)->nullable();
            $table->text('load_shipperr')->nullable();
            $table->longText('load_shipper_location')->nullable();
            $table->longText('load_shipper_date')->nullable();
            $table->longText('load_shipper_time')->nullable();
            $table->longText('load_shipper_discription')->nullable();
            $table->string('load_shipper_commodity_type', 255)->nullable();
            $table->string('load_shipper_qty', 255)->nullable();
            $table->string('load_shipper_weight', 255)->nullable();
            $table->string('load_shipper_commodity', 255)->nullable();
            $table->string('load_shipper_value', 255)->nullable();
            $table->longText('load_shipper_shipping_notes')->nullable();
            $table->string('load_shipper_po_numbers', 255)->nullable();
            $table->string('load_shipper_contact', 255)->nullable();
            $table->string('load_shipper_appointment', 255)->nullable();
            $table->longText('load_consignee')->nullable();
            $table->longText('load_consignee_location')->nullable();
            $table->longText('load_consignee_date')->nullable();
            $table->longText('load_consignee_time')->nullable();
            $table->longText('load_consignee_discription')->nullable();
            $table->longText('load_consignee_type')->nullable();
            $table->longText('load_consignee_qty')->nullable();
            $table->longText('load_consignee_weight')->nullable();
            $table->longText('load_consignee_commodity')->nullable();
            $table->longText('load_consignee_value')->nullable();
            $table->longText('load_consignee_delivery_notes')->nullable();
            $table->longText('load_consignee_po_numbers')->nullable();
            $table->longText('load_consignee_pro_miles')->nullable();
            $table->longText('load_consignee_empty')->nullable();
            $table->longText('load_consignee_appointment')->nullable();
            $table->date('load_actual_delivery_date')->nullable();
            $table->longText('load_consigneer_contact')->nullable();
            $table->string('invoice_status', 50)->nullable();
            $table->dateTime('invoice_status_date')->nullable();
            $table->longText('load_consigneer_notes')->nullable();
            $table->string('load_shipper_rate', 255)->nullable();
            $table->string('shipper_load_final_rate', 100)->nullable();
            $table->string('comment', 255)->nullable();
            $table->longText('public_file')->nullable();
            $table->dateTime('public_file_upload_date')->nullable();
            $table->string('invoice_number', 100)->nullable();
            $table->string('invoice_date', 100)->nullable();
            $table->string('load_carrier_due_date', 50)->nullable();
            $table->string('load_carrier_due_date_on', 20)->nullable();
            $table->string('carrier_mark_as_paid', 10)->nullable();
            $table->longText('load_consignee_contact')->nullable();
            $table->string('receiving_amount', 100)->nullable();
            $table->string('remaining_amount', 100);
            $table->longText('carrierDoc')->nullable();
            $table->longText('cpr_check')->nullable();
            $table->string('macro', 250)->nullable();
            $table->string('no_of_macro', 250)->nullable();
            $table->string('quick_pay', 50)->nullable();
            $table->string('payment_method', 50)->nullable();
            $table->string('ready_to_pay', 50)->nullable();
            $table->longText('customer_refrence_number')->nullable();
            $table->longText('internal_notes')->nullable();
            $table->string('invoicing_payment_terms', 255)->nullable();
            $table->dateTime('paper_work_date')->nullable();
            $table->dateTime('payment_receiving_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loads');
    }
};
