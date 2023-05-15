<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Starship extends Model
{

    protected $fillable = [
        'name',
        'model',
        'manufacturer',
        'cost_in_credits',
        'length',
        'max_atmosphering_speed',
        'crew', 'passengers',
        'cargo_capacity',
        'consumables',
        'hyperdrive_rating',
        'MGLT',
        'starship_class',
        'pilots',
        'films',
        'created',
        'edited',
    ];

    public function pilots()
    {
        return $this->belongsToMany(Pilot::class, 'starship_pilot');
    }

}
