<?php

namespace App\Http\Controllers\UploadData;

use Illuminate\Http\Request;
use App\Models\Coin;
use App\Models\PriceCriptopia;

class DownCriptopiaController extends BaseDataController
{
    public function downloadPrice()
    {
    	$allData = Coin::all();
    	foreach ($allData as $key) {
    		//dump($ListCoins = $this->DownloanJson('https://bittrex.com/api/v1.1/public/getmarketsummary?market=btc-'.$key->tag));
    		//debug($key);
    		$ListCoins = $this->DownloanJson("https://www.cryptopia.co.nz/api/GetMarket/{$key->tag}_BTC");
    		debug($ListCoins);
    		if($ListCoins['Success'] == true && $ListCoins['Error'] == null){
    			$ListCoins = $ListCoins['Data'];
    			PriceCriptopia::updateOrCreate(['coin_id'=>$key->coin_id, 'coin_id'=>$key->coin_id], ['High'=>$ListCoins['High'],'Low'=>$ListCoins['Low'],
    			'Last'=>$ListCoins['LastPrice']]);
    		}
    	}
    	





    	return 1;
    }
}
