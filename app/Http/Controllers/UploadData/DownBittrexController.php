<?php

namespace App\Http\Controllers\UploadData;

use Illuminate\Http\Request;
use App\Models\Coin;
use App\Models\PriceBittrex;

class DownBittrexController extends BaseDataController
{
    public function downloadPrice()
    {
    	$allData = Coin::all();
    	foreach ($allData as $key) {
    		//dump($ListCoins = $this->DownloanJson('https://bittrex.com/api/v1.1/public/getmarketsummary?market=btc-'.$key->tag));
    		//debug($key);
    		$ListCoins = $this->DownloanJson('https://bittrex.com/api/v1.1/public/getmarketsummary?market=btc-'.$key->tag);
    		if($ListCoins['message'] == "" && $ListCoins['success'] == true){
    			$ListCoins = $ListCoins['result'][0];
    			PriceBittrex::updateOrCreate(['coin_id'=>$key->coin_id, 'coin_id'=>$key->coin_id], ['High'=>$ListCoins['High'],'Low'=>$ListCoins['Low'],'Last'=>$ListCoins['Last']]);
    		}
    	}
        $this->PriceUsdBtc((new PriceBittrex));
    	
    	return 1;
    }
}
