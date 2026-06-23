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
            $table->string('name');
            $table->text('display_name');
            $table->string('address_type', 50);
            $table->decimal('lat');
            $table->decimal('lon');
            $table->string('osm_id');
            $table->string('osm_type');
            $table->string('osm_type');
            $table->string('state')->nullable();
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
