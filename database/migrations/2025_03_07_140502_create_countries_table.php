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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // Country name (varchar(100))
            $table->char('iso3', 3)->nullable(); // 3-letter ISO country code
            $table->char('numeric_code', 3)->nullable(); // Numeric country code
            $table->char('iso2', 2)->nullable(); // 2-letter ISO country code
            $table->string('phonecode', 255)->nullable(); // Phone code
            $table->string('capital', 255)->nullable(); // Capital city
            $table->string('currency', 255)->nullable(); // Currency
            $table->string('currency_name', 255)->nullable(); // Currency name
            $table->string('currency_symbol', 255)->nullable(); // Currency symbol
            $table->string('tld', 255)->nullable(); // Top-level domain
            $table->string('native', 255)->nullable(); // Native country name
            $table->string('region', 255)->nullable(); // Region (e.g., Europe)
            $table->mediumInteger('region_id')->unsigned()->nullable(); // Region ID (unsigned)
            $table->string('subregion', 255)->nullable(); // Subregion (e.g., Northern Europe)
            $table->mediumInteger('subregion_id')->unsigned()->nullable(); // Subregion ID (unsigned)
            $table->string('nationality', 255)->nullable(); // Nationality
            $table->text('timezones')->nullable(); // Timezones (text)
            $table->text('translations')->nullable(); // Translations (text)
            $table->decimal('latitude', 10, 8)->nullable(); // Latitude
            $table->decimal('longitude', 11, 8)->nullable(); // Longitude
            $table->string('emoji', 191)->nullable(); // Country emoji
            $table->string('emojiU', 191)->nullable(); // Unicode representation of emoji
            $table->boolean('flag')->default(1); // Flag (tinyint(1), default 1)
            $table->string('wikiDataId', 255)->nullable()->comment('Rapid API GeoDB Cities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
