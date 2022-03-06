<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    public $incrementing = false;

    public function facilities(){
        return $this->hasMany('App\Facility','category_id');
    }
}
