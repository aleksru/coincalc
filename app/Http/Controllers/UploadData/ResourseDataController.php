<?php

namespace App\Http\Controllers\UploadData;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Coin;
use App\Models\Algoritm;
use App\Models\DataCoin;

class ResourseDataController extends BaseDataController
{
    public function UpWhatToMine()
    {
    	$semafor = 0;
        $ListCoins = $this->DownloanJson('https://whattomine.com/calculators.json');
        

        foreach($ListCoins as $coins){

        	foreach($coins as $coin => $value){

        		if($value["status"] == "Active"){
        			Cache::add($semafor, 'https://whattomine.com/coins/'.$value['id'].'.json', 5);
        			$semafor++;
        			Coin::firstOrCreate(['coin_id' => $value["id"], 'tag' => $value["tag"], 'name' => $coin, 'algoritm_id' => Algoritm::firstOrCreate(['name' => $value["algorithm"]])->id]);
        		}
        	}
        }
        //echo $semafor.'<br>';
        for($i = 0; $i <= $semafor; $i++){
        	//debug(Cache::get($i));
			try{
				if(Cache::get($i)){
					$DataCoin = $this->DownloanJson(Cache::get($i));
				}
				Cache::forget($i);
	        }catch(\Exception $e){
	        		sleep(10);
	        		continue;
	      		}
	      	//debug(['coin_id' => $DataCoin['id'], 'block_time' => (float)$DataCoin['block_time'],'block_reward' => $DataCoin['block_reward'], 'nethash' => $DataCoin['nethash']]);
	      	
	      	//$data = ['coin_id' => $DataCoin['id'], 'block_time' => (float)$DataCoin['block_time'],'block_reward' => $DataCoin['block_reward'], 'nethash' => $DataCoin['nethash']];

	        $savedata = DataCoin::firstOrNew(['coin_id' => $DataCoin['id']]);
	      	$savedata->block_time = (float)$DataCoin['block_time'];
	      	$savedata->block_reward = $DataCoin['block_reward'];
	      	$savedata->nethash = $DataCoin['nethash'];
	      	$savedata->save();
	      	//dump($savedata);
	    }
	    Cache::flush();


        return 1;
    }



}