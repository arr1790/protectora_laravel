<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    // Laravel buscará la tabla order_product de forma predeterminada
    protected $table = 'order_product';  // Nombre de la tabla intermedia

    protected $fillable = [
        'order_id', // Relación con la tabla orders
        'product_id', // Relación con la tabla products
        'quantity', // Cantidad del producto
        'price' // Precio del producto en el momento del pedido
    ];
}
