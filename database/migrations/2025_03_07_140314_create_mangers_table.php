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
        Schema::create('mangers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('manager', 255);
            $table->string('leader_email', 255);
            $table->string('leader_manager', 255);
            $table->string('office', 100)->nullable();
            $table->string('department', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mangers');
    }
};
