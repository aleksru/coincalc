<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Algoritm extends Model
{
   public $timestamps = false;
   protected $fillable = ['name'];


    public function coin()
    {
        return $this->hasMany('App\Models\Coin');
    }
}
