<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductTable extends Migration
{
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->id(); // ID de la relación
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Relación con la tabla orders
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Relación con la tabla products
            $table->integer('quantity'); // Cantidad del producto en el pedido
            $table->decimal('price', 10, 2); // Precio del producto en el momento de la compra
            $table->timestamps(); // Fecha de creación y actualización
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_product');
    }
}
