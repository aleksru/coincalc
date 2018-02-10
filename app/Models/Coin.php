<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    protected $fillable = ['tag', 'name', 'coin_id', 'algoritm_id'];
    public $timestamps = false;


    public function algoritm()
    {
        return $this->belongsTo('App\Models\Algoritm');
    }

    public function datacoin()
  	{
    	return $this->hasOne('App\Models\DataCoin', 'coin_id', 'coin_id');
  	}

    public function price()
    {
        return $this->hasMany('App\Models\PriceBittrex', 'coin_id', 'coin_id');
    }

    public function priceHitbtc()
    {
        return $this->hasMany('App\Models\PriceHitbtc', 'coin_id', 'coin_id');
    }
    
    public function priceCriptopia()
    {
        return $this->hasMany('App\Models\PriceCriptopia', 'coin_id', 'coin_id');
    }

    public function priceYobit()
    {
        return $this->hasMany('App\Models\PriceYobit', 'coin_id', 'coin_id');
    }

}
