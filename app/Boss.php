<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boss extends Model
{
    protected $fillable = [
        'id', 'name', 'cp', 'imagem', 'in_raid'
    ];
    
    public function raids()
    {
        return $this->hasMany('App\Raid');
    }
}
