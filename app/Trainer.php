<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $fillable = [
        'id', 'nickname', 'pkm_code', 'level'
    ];
    
    
    public function raids()
    {
        return $this->belongsToMany('App\Raid', 'raids_list', 'trainers_id', 'raids_id');
    }
}
