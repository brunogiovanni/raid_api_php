<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    protected $fillable = [
        'id', 'name', 'location', 'ex'
    ];
    
    public function raids()
    {
        return $this->hasMany('App\Raid');
    }
}
