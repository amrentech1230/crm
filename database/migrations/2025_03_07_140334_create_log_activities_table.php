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
        Schema::create('log_activities', function (Blueprint $table) {
            $table->id();
            $table->string('subject', 255);
            $table->string('url', 255);
            $table->string('method', 255);
            $table->string('ip', 255);
            $table->string('agent', 255)->nullable();
            $table->integer('user_id')->nullable();
            $table->string('user_name', 255)->nullable();
            $table->string('user_email', 255)->nullable();
            $table->string('user_role', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_activities');
    }
};
