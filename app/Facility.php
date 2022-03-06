<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $table = 'facilities';
    protected $primaryKey = 'facility_id';
    public $incrementing = false;

    public function category(){
        return $this->belongsTo('App\Category','category_id');
    }
    public function lga(){
        return $this->belongsTo('App\Lga','lga_code');
    }
}