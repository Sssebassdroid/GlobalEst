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
            $table->id();
            $table->integer('position');
            $table->foreignId('place_id')->constrained('place');
            $table->foreignId('tour_id')->constrained('tour');
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
