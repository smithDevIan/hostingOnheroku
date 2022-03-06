<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';
    protected $primaryKey = 'state_code';
    public $incrementing = false;

    public function lgas(){
        return $this->hasMany('App\Lga','state_code');
    }
}
