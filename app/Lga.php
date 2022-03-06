<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lga extends Model
{
    protected $table = 'lgas';
    protected $primaryKey = 'lga_code';
    public $incrementing = false;

    public function state(){
        return $this->belongsTo('App\State', 'state_code');
    }
    public function lgas(){
        return $this->hasMany('App\Facility', 'lga_code');
    }
}
