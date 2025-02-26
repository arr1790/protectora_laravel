<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HaztePadrino extends Model
{
    use HasFactory;

    
    protected $table = 'hazte_padrinos';

    protected $fillable = [
        'name',
        'surname',
        'address',
        'dni',
        'city',
        'user_id',
        'animal_id',
        'phone',
        'email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el modelo Animal
     * Un padrino tiene un animal.
     */
    public function animal()
    {
        return $this->belongsTo(Animals::class);
    }
}
