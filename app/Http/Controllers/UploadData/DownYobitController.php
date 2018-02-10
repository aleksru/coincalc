<?php

namespace App\Http\Controllers\UploadData;

use Illuminate\Http\Request;
use App\Models\Coin;
use App\Models\PriceYobit;

class DownYobitController extends BaseDataController
{
    public function downloadPrice()
    {
    	$allData = Coin::all();
    	//$ListCoins = file_get_contents('https://yobit.net/api/3/ticker/adz_btc');
        $semafor = 0;
        $query = "https://yobit.net/api/3/ticker/";
        $s = $query;
        $arrQueryes = [];

    	foreach ($allData as $key) {
    		$lower = strtolower($key->tag);
            //$ListCoins = $this->DownloanJson("https://yobit.net/api/3/ticker/{$lower}_btc");
            //sleep(2);
            if($semafor == 0){
                $s = $s."{$lower}_btc";
            }else{
                $s = $s."-{$lower}_btc";
            }
            if($semafor > 15){
                $s = $s."-error_pair?ignore_invalid=1";
                $arrQueryes[] = $s;
                $semafor = 0;
                $s = $query;
            }
            $semafor++;
    	}

        foreach($arrQueryes as $res){
            $ListCoins = $this->DownloanJson($res);
            foreach ($ListCoins as $key => $value) {
                $getcoin = Coin::where("tag", substr($key, 0, -4))->get();
                    PriceYobit::updateOrCreate(['coin_id'=>$getcoin[0]->coin_id, 'coin_id'=>$getcoin[0]->coin_id], ['High'=>$value['high'], 'Low'=>$value['low'],  'Last'=>$value['last']]);
            }
            sleep(3);
        }

    	return 1;
    }

}
