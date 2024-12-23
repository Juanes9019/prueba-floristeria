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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->enum('tipo_documento', ["CC", "CE", "Pasaporte"])->default("CC");
            $table->string('documento')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('celular')->nullable();
            $table->foreignId('id_rol')->default(2)->constrained('roles');
            $table->string('password');
            $table->integer('estado')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
