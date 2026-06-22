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
        Schema::create('booking_detail', function (Blueprint $table) {
    $table->id('id_booking_detail');
    $table->integer('quantity');
    $table->decimal('subtotal', 10, 2);
    $table->foreignId('order_id')->constrained('orders', 'id_order');
    $table->foreignId('occurrence_id')->constrained('occurrence', 'id_occurrence');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_details');
    }
};
