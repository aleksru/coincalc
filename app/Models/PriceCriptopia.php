<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceCriptopia extends Model
{
    protected $table = 'price_criptopia';
    protected $fillable = ['coin_id','High','Low','Last'];

    public function coin()
  	{
    	return $this->belongsTo('App\Models\Coin', 'coin_id', 'coin_id');
  	}
}
