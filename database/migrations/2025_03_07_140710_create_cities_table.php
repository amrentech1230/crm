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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255); // City name
            $table->unsignedMediumInteger('state_id'); // State ID, unsigned medium integer
            $table->string('state_code', 255); // State code (e.g., "CA" for California)
            $table->unsignedMediumInteger('country_id'); // Country ID, unsigned medium integer
            $table->char('country_code', 2); // Country code (2 characters, e.g., "US")
            $table->decimal('latitude', 10, 8); // Latitude, stored as decimal with precision (10,8)
            $table->decimal('longitude', 11, 8); // Longitude, stored as decimal with precision (11,8)
            $table->string('wikiDataId', 255)->nullable()->comment('Rapid API GeoDB Cities'); // Wiki Data ID (nullable)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
