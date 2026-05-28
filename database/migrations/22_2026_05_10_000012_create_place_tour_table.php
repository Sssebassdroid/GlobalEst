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
        Schema::create('place_tour', function (Blueprint $table) {
    $table->id('id_places_tour');
    $table->integer('order_position')->default(1);
    $table->foreignId('place_id')->constrained('places_available', 'id_place');
    $table->foreignId('tour_id')->constrained('tour', 'id_tour');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('place_tour');
    }
};
