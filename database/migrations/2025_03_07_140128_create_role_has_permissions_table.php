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
        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('permission_id', false, true)->unsigned(); // permission_id (bigint UNSIGNED NOT NULL)
            $table->bigInteger('role_id', false, true)->unsigned(); // role_id (bigint UNSIGNED NOT NULL)
            $table->bigInteger('read', false, true)->unsigned(); // read permission (bigint UNSIGNED NOT NULL)
            $table->bigInteger('write', false, true)->unsigned(); // write permission (bigint UNSIGNED NOT NULL)
            $table->bigInteger('create', false, true)->unsigned(); // create permission (bigint UNSIGNED NOT NULL)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_has_permissions');
    }
};
