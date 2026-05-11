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
     Schema::create('places_available', function (Blueprint $table) {
    $table->id('id_place');
    $table->text('name');
    $table->text('display_name');
    $table->decimal('latitude', 10, 8);
    $table->decimal('longitude', 11, 8);
    $table->float('importance')->nullable();
    $table->bigInteger('osm_id')->nullable();
    $table->string('osm_type', 20)->nullable();
    $table->foreignId('city_id')->constrained('city', 'id_city');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places_available');
    }
};
