<?php

namespace App\Http\Controllers\UploadData;

use Illuminate\Http\Request;
use App\Models\Coin;
use App\Models\PriceHitbtc;

class DownHitbtcController extends BaseDataController
{
    public function downloadPrice()
    {
    	$ListCoins1 = $this->DownloanJson("https://api.hitbtc.com/api/2/public/ticker/XEMBTC");
    	debug($ListCoins1);
    	$allData = Coin::all();
    	foreach ($allData as $key) {
    		//dump($ListCoins = $this->DownloanJson('https://bittrex.com/api/v1.1/public/getmarketsummary?market=btc-'.$key->tag));
    		//debug($key);
    		$ListCoins = $this->DownloanJson("https://api.hitbtc.com/api/2/public/ticker/{$key->tag}BTC");
    		debug($ListCoins);
    		if($ListCoins){
    			PriceHitbtc::updateOrCreate(['coin_id'=>$key->coin_id, 'coin_id'=>$key->coin_id], ['High'=>$ListCoins['high'],'Low'=>$ListCoins['low'],
    			'Last'=>$ListCoins['last']]);
    		}
    	}
    	





    	return 1;
    }
}
