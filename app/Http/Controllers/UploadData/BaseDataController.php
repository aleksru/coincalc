<?php

namespace App\Http\Controllers\UploadData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PriceBittrex;

class BaseDataController extends Controller
{
    protected function DownloanJson($url)
    {
    	try{        
    		$j = file_get_contents($url);
        	$j = json_decode($j, true);

        	
        }catch(\Exception $e){
	        	return null;
	    }

	    return $j;

    }

    public function PriceUsdBtc($price)
    {
        $ListCoins = $this->DownloanJson("https://api.coinmarketcap.com/v1/ticker/bitcoin/");
        if($ListCoins){
            $ListCoins = $ListCoins[0];
            $price::updateOrCreate(['coin_id'=>1, 'coin_id'=>1], ['High'=>$ListCoins['price_usd'],'Low'=>$ListCoins['price_usd'],'Last'=>$ListCoins['price_usd']]);
        }
    }


}
