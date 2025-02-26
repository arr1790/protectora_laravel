<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();  // ID del pedido
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con el usuario que hace el pedido
            $table->decimal('total', 10, 2); // Total del pedido
            $table->enum('status', ['pendiente', 'procesando', 'completado', 'cancelado']); // Estado del pedido
            $table->timestamps(); // Fecha de creación y actualización
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
