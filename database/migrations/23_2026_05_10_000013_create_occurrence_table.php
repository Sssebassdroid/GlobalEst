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
        Schema::create('occurrence', function (Blueprint $table) {
    $table->id('id_occurrence');
    $table->date('date_occurrence');
    $table->time('start_hour');
    $table->integer('maximum_person');
    $table->foreignId('tour_id')->constrained('tour', 'id_tour');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ocurrence');
    }
};
