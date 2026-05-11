<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración para crear la tabla de usuarios.
     */
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('username', 50)->unique();
            $table->string('name', 50);
            $table->string('first_last_name', 50);
            $table->string('second_last_name', 50)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('role_id')->constrained('role', 'id_role');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración eliminando la tabla.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};