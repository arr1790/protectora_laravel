<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animals extends Model
{
    use HasFactory;
  

    protected $fillable = [
        'name', 
        'race', 
        'age', 
        'sex', 
        'size', 
        'description', 
        'status', 
        'image'
    ];
    


    /**
     * Relación: Un animal pertenece a un usuario (dueño).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Relación con el dueño (usuario)
    }
}
