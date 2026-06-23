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
        Schema::create('subregions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // Name column (varchar(100))
            $table->text('translations')->nullable(); // Translations column (text, nullable)
            $table->mediumInteger('region_id')->unsigned(); // Region ID (mediumint(8) unsigned)
            $table->tinyInteger('flag')->default(1); // Flag column (tinyint(1), default value is 1)
            $table->string('wikiDataId', 255)->nullable()->comment('Rapid API GeoDB Cities'); // WikiDataId column (varchar(255), nullable)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subregions');
    }
};
