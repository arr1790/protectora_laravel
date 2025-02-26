<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitudAdopcion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'animal_id', 'user_id', 'request_date', 'adoption_date'
    ];

    /**
     * Relación: Una solicitud de adopción pertenece a un animal.
     */
    public function animal()
    {
        return $this->belongsTo(Animals::class, 'animal_id'); // Relación con el modelo Animal
    }

    /**
     * Relación: Una solicitud de adopción pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Relación con el modelo User
    }
}