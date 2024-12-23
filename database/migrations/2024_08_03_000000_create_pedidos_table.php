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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->decimal('total', 10, 2);
            $table->timestamp('fechapedido');
            $table->enum('estado', ["nuevo", "preparacion", "en camino", "entregado","rechazado","no recibido"])->default("nuevo");
            $table->string('comprobante_url')->nullable();
            $table->json('datos_envio');
            $table->json('datos_rechazo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
