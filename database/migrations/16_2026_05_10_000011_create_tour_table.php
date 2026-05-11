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
        Schema::create('tour', function (Blueprint $table) {
    $table->id('id_tour');
    $table->string('tour_name', 100);
    $table->decimal('tour_price', 10, 2);
    $table->text('description')->nullable();
    $table->time('estimated_duration');
    $table->string('image')->nullable();
    $table->foreignId('agency_id')->constrained('agency', 'id_agency');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour');
    }
};
