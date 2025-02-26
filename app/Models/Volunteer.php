<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Volunteer extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'phone',
        'date_volunteers',
        'task',
        'weekly_hours',
        'user_id'
    ];


    public function user() {
        return $this->belongsTo(User::class);
    }


}
