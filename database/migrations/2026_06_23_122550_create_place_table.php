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
        Schema::create('place', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('display_name');
            $table->string('address_type', 50);
            $table->decimal('lat', 10, 7);
            $table->decimal('lon', 10, 7);
            $table->string('osm_id')->nullable();
            $table->string('osm_type')->nullable();
            $table->string('state')->nullable();
            $table->decimal('importance')->nullable();
            $table->foreignId('city_id')->constrained('city');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('place');
    }
};
