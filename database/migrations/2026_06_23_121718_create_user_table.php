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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('username', 50)->unique();
            $table->string('name', 50);
            $table->string('last_name', 50);
            $table->string('second_last_name', 50)->nullable();
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->foreignId('role_id')->constrained('role');
            $table->rememberToken()->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
