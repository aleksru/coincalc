<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Coin;
use App\Models\PriceBittrex;
use App\Models\PriceCriptopia;
use App\Models\PriceHitbtc;
use App\Models\PriceYobit;

class PriceController extends Controller
{
	protected $var;

	public function __construct(Coin $coin) {
		$this->var = $coin;
	}



    public function getPrices()
    {

    	return [($this->var)->price, ($this->var)->priceHitbtc, ($this->var)->priceCriptopia, ($this->var)->priceYobit];

    }

    public function getMaxPrices()
    {	

    	return collect(["priceBittrex" =>!$this->var->price->isEmpty()?$this->var->price[0]->High:null,
    			"priceHitbtc" =>!$this->var->priceHitbtc->isEmpty()?$this->var->priceHitbtc[0]->High:null,
    			"priceCriptopia" =>!$this->var->priceCriptopia->isEmpty()?$this->var->priceCriptopia[0]->High:null,
    			"priceYobit" =>!$this->var->priceYobit->isEmpty()?$this->var->priceYobit[0]->High:null]);

    }

	public function getLastPrices()
    {	

	   return collect(["priceBittrex" =>!$this->var->price->isEmpty()?$this->var->price[0]->Last:null,
			"priceHitbtc" =>!$this->var->priceHitbtc->isEmpty()?$this->var->priceHitbtc[0]->Last:null,
			"priceCriptopia" =>!$this->var->priceCriptopia->isEmpty()?$this->var->priceCriptopia[0]->Last:null,
			"priceYobit" =>!$this->var->priceYobit->isEmpty()?$this->var->priceYobit[0]->Last:null]);
    }

   	public function getLowPrices()
    {	

	   return ["priceBittrex" =>!$this->var->price->isEmpty()?$this->var->price[0]->Low:null,
			"priceHitbtc" =>!$this->var->priceHitbtc->isEmpty()?$this->var->priceHitbtc[0]->Low:null,
			"priceCriptopia" =>!$this->var->priceCriptopia->isEmpty()?$this->var->priceCriptopia[0]->Low:null,
			"priceYobit" =>!$this->var->priceYobit->isEmpty()?$this->var->priceYobit[0]->Low:null];
    }

    public function getAvgPrices()
    {   

        return collect([!$this->var->price->isEmpty()?$this->var->price[0]->Last:null, 
                    !$this->var->priceHitbtc->isEmpty()?$this->var->priceHitbtc[0]->Last:null, 
                    !$this->var->priceCriptopia->isEmpty()?$this->var->priceCriptopia[0]->Last:null,
                    !$this->var->priceYobit->isEmpty()?$this->var->priceYobit[0]->Last:null])->filter()->avg();
    }

    public function getOneMaxPrice()
    {
        return $this->getMaxPrices()->max();
    }
}
