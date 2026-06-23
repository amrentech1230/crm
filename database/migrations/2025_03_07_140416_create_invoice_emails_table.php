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
        Schema::create('invoice_emails', function (Blueprint $table) {
            $table->id();
            $table->string('from_email', 255);
            $table->string('to_email', 255);
            $table->longText('cc_email')->nullable();
            $table->string('subject', 255);
            $table->text('message');
            $table->longText('attachments')->nullable();           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_emails');
    }
};
