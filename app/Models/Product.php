<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'description', 'image', 'user_id'];

    // Relación muchos a muchos con pedidos a través de la tabla intermedia
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')
                    ->withPivot('quantity', 'price') // Información adicional (cantidad, precio)
                    ->withTimestamps();
    }
}
