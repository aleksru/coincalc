<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataCoin extends Model
{
    protected $fillable = ['coin_id', 'block_time', 'block_reward', 'block_reward24', 'nethash'];
    protected $table = 'datacoins';


    public function coin()
  	{
    	return $this->belongsTo('App\Models\Coin', 'coin_id', 'coin_id');
  	}
}
