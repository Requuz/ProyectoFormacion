<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pilot extends Model
{

    protected $fillable = [
        'name',
        'height',
        'mass',
        'hair_color',
        'skin_color',
        'eye_color',
        'birth_year',
        'gender',
        'homeworld',
        'created',
        'edited',
    ];

    public function starships()
    {
        return $this->belongsToMany(Starship::class, 'starship_pilot');
    }
}
