<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Raid extends Model
{
    protected $fillable = [
        'id', 'gyms_id', 'bosses_id', 'climate', 'strong_attack', 'data_hora'
    ];
    
    public function boss()
    {
        return $this->belongsTo('App\Boss', 'bosses_id');
    }
    
    public function gym()
    {
        return $this->belongsTo('App\Gym', 'gyms_id');
    }
    
    public function trainers()
    {
        return $this->belongsToMany('App\Trainer', 'raids_list', 'raids_id', 'trainers_id');
    }
}
