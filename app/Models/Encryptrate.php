<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encryptrate extends Model
{

	public $timestamps = false;


    public function encalgoritm()
  	{
    	return $this->hasMany('App\Models\Algoritm', 'encryptrate_id');
  	}


}
