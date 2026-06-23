<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {

    /**
     * Run the migrations.
     */

    public function up(): void

    {

        Schema::create('booking_detail', function (Blueprint $table) {

            $table->id();

            $table->integer('quantity');

            $table->decimal('price_per_unit');

            $table->foreignId('booking_id');

            $table->foreignId('occurrence_id');

            $table->timestamps('created_at');

        });

    }


    /**
     * Reverse the migrations.
     */

    public function down(): void

    {

        Schema::dropIfExists('booking_detail');

    }

};
