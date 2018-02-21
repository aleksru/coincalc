<?php

namespace App\Http\Controllers\UploadData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function PriceUsdBtc()
    {
        $this->DownloanJson("https://api.coinmarketcap.com/v1/ticker/bitcoin/");


        return dump($this->DownloanJson("https://api.coinmarketcap.com/v1/ticker/bitcoin/"));
    }
}
