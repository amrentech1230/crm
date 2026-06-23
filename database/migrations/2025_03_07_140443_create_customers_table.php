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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('customer_name', 255);
            $table->string('customer_mc_ff', 255);
            $table->string('customer_mc_ff_input', 255);
            $table->string('customer_address', 255);
            $table->string('customer_country', 255);
            $table->string('customer_state', 255);
            $table->string('customer_city', 255);
            $table->string('customer_zip', 255);
            $table->string('customer_billing_address', 255);
            $table->string('customer_billing_country', 255);
            $table->string('customer_billing_state', 255);
            $table->string('customer_billing_city', 255);
            $table->string('customer_billing_zip', 255);
            $table->string('customer_primary_contact', 255);
            $table->string('customer_telephone', 255);
            $table->string('customer_extn', 255);
            $table->string('customer_email', 255);
            $table->string('customer_tollfree', 255);
            $table->string('customer_fax', 255);
            $table->string('customer_secondary_contact', 255);
            $table->string('customer_secondary_email', 255);
            $table->string('customer_billing_email', 255);
            $table->string('customer_billing_telephone', 255);
            $table->string('customer_billing_extn', 255);
            $table->string('customer_blacklisted', 255);
            $table->string('customer_corporation', 255);
            $table->string('adv_customer_currency_Setting', 255)->nullable();
            $table->longText('approved_limit')->nullable();
            $table->float('adv_customer_credit_limit')->nullable();
            $table->float('remaining_credit')->nullable();
            $table->longText('credit_limit_log')->nullable();
            $table->longText('remaining_credit_logs')->nullable();
            $table->longText('invoice_credit_limit')->nullable();
            $table->string('remaining_credit_amount', 100)->nullable();
            $table->string('total_revenue', 100)->nullable();
            $table->string('adv_customer_payment_terms', 255)->nullable();
            $table->string('adv_customer_factoring_company', 255)->nullable();
            $table->string('adv_customer_webiste_url', 255)->nullable();
            $table->string('adv_customer_duplicate', 255)->nullable();
            $table->string('adv_customer_duplicate_two', 255)->nullable();
            $table->text('adv_customer_internal_notes')->nullable();
            $table->string('adv_customer_payment_terms_custome', 255)->nullable();
            $table->string('customer_status', 255)->nullable();
            $table->string('status', 255)->nullable();
            $table->string('customer_file_upload', 1000);
            $table->string('commenter_name', 100)->nullable();
            $table->longText('comment_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
