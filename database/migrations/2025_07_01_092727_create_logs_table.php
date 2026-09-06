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
        if (!Schema::hasTable('logs')) {
            Schema::create('logs', function (Blueprint $table) {
                 $table->id();
                $table->string('load_id')->nullable(); 
                $table->string('customer_id')->nullable();
                $table->string('message')->nullable();
                $table->string('user_name')->nullable();
                $table->string('user_id')->nullable();
                $table->string('user_email')->nullable();
                $table->text('old_json')->nullable(); 
                $table->text('new_json')->nullable();
                $table->ipAddress('ip')->nullable(); 
                $table->string('url')->nullable(); 
                $table->timestamps(); 
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
