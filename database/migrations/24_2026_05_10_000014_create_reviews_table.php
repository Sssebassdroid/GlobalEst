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
        Schema::create('reviews', function (Blueprint $table) {
    $table->id('id_review');
    $table->integer('rating');
    $table->text('comment')->nullable();
    $table->foreignId('user_id')->constrained('user', 'id_user');
    $table->foreignId('tour_id')->constrained('tour', 'id_tour');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
