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
        Schema::create('team_leaders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('department', 255)->nullable();
            $table->string('tl', 255);
            $table->string('leader_email', 255);
            $table->string('leader_manager', 255);
            $table->string('office', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_leaders');
    }
};
