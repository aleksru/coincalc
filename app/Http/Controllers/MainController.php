<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Coin;
use App\Models\Videocard;
use App\Models\Algoritm;
use App\Models\DataCoin;
use App\Models\Hashrate;
use App\Http\Controllers\PriceController;

//use App\Models\PriceBittrex;



class MainController extends Controller
{

    public function index()
    {   
        $msg = '';
        $AlgEnc = DB::table('algoritms')->join('encryptrates', 'algoritms.encryptrate_id', '=', 'encryptrates.id')->select('algoritms.name as algname','algoritms.id as algid','encryptrates.id as encid' ,'encryptrates.name as encname')->get();
        //debug($AlgEnc);
        //debug(Videocard::all());
        //debug(Videocard::find(2)->hashrates);
        return view('index', ['videocard' => Videocard::all(), 'title' => 'Главная', 'algoritm' => $AlgEnc, 'msg' => $msg]);
    }
    
    public function postindex(Request $request){
        //debug($request);
        if(isset($request->videocart)){
            $gethash = Videocard::find($request->videocart);
            $arrayColl = [];
            foreach($gethash->hashrates as $rate){
                //echo '<h1>'.$rate->name.'</h1>'.'<br>';
                $res = $this->summary($rate->pivot->userhash, $rate->id);
                //dump($res);
                //dump($res['BitcoinGold']);
                //dump($res['BitcoinGold'][1]->getMaxPrices());
                foreach ($this->summary($rate->pivot->userhash, $rate->id) as $key => $value) {
                    $arrayColl[] = collect(['coin'=>$key, 'encrypt'=> $rate->name, 'avg price' => $value[1]->getAvgPrices(), 'avg profit' => $value[0]*$value[1]->getAvgPrices()*8361, 'max price' => $value[1]->getOneMaxPrice(), 'max profit' => $value[1]->getOneMaxPrice()*$value[0]*8361]);
                }
            }
            $arrayColl = collect($arrayColl)->reject(function ($value, $key){
                return !$value['max profit'] && !$value['avg profit'];
            });

            dump($arrayColl);

        }
        foreach ($request->all() as $key => $value) {
           if(substr($key, 0, 6) == 'algenc' && !empty($value)){
                $key = explode("/", $key);
                $result = $this->summary($this->math($value, $key[2]), $key[1]);
                dump($result);
           }
        }

    }

    public function ajax(Request $request)
    {
        return $this->postindex($request);
    }
    


    public function math($hash, $numb)
    {
    	// $b = (23.3*1e6)/(1.7856257368148E+14);
    	// $h = 3600 / 14.3602;
    	// $res1 = 2.91*$b*$h*24;
    	// $res1 = round($res1, 4);
        /*
1 MH/s = 1,000 kH/s = 1,000,000 H/s
1 GH/s = 1,000 MH/s = 1,000,000 kH/s
1 TH/s = 1,000 GH/s = 1,000,000 MH/s = 1,000,000,000 kH/s = 1,000,000,000,000 H/s
*/

        if($numb != 5){
            if($numb == 4){$hash = $hash * 1000;}
            if($numb == 3){$hash = $hash * 1000000;}
            if($numb == 2){$hash = $hash * 1000000 * 1000;}
            if($numb == 1){$hash = $hash * 1000000000000;}
        }
    	return $hash;
    }


    public function summary($userhash, $algoritm_id)
    {	
        //debug($userhash);
    	$arr = Algoritm::find($algoritm_id)->coin;
        $result = [];

    	foreach($arr as $key){
    		$b = ($userhash)/($key->datacoin->nethash);
	    	$h = 3600 / $key->datacoin->block_time;
            //$price = $key->price;
	    	//$res1 = $key->datacoin->block_reward *$b*$h*24;
	    	//$res1 = round($res1, 5);
            $priceCoin = (new PriceController($key));
            $result[$key->datacoin->coin->name] = [round($key->datacoin->block_reward *$b*$h*24, 5), $priceCoin];
	    	//echo $key->datacoin->coin->name.' '.$res1.'<br>';

    	}



    	return $result;
    }

    public function GetCoinsHash()
    {

    	$geth = Videocard::find(2)->hashrates;
    	//echo Videocard::find(2)->name.'<br>';
    	//debug($geth);

    	$getnumb = Videocard::find(2);
    	debug($getnumb->hashrates);
    	foreach($getnumb->hashrates as $rate){
    		debug($rate->pivot->userhash);
    	}




    	return 1;
    }


    public function CheckCoinsAlg()
    {	
    	$allaltm = App\Models\Algoritm::all();
    	
    	foreach($allaltm as $alg){
    		echo '<h1>'.$alg->name.'</h1>'.'<br>'.'<br>';
    		foreach($alg->coin as $coin){
    			echo $coin->name.'<br>';
    			debug($coin->name);
    		}
    	}

    	return 1;
    }


    public function GetAddVideoCard($msg = '')
    {	
    	//$allaltm = Algoritm::all();
    	//$allVcard = Videocard::all();

    	return view('addvideocart', ['videocard' => Videocard::all(), 'title' => 'Add', 'algoritm' => Algoritm::all(), 'msg' => $msg]);
    }

/*
1 MH/s = 1,000 kH/s = 1,000,000 H/s
1 GH/s = 1,000 MH/s = 1,000,000 kH/s
1 TH/s = 1,000 GH/s = 1,000,000 MH/s = 1,000,000,000 kH/s = 1,000,000,000,000 H/s
*/


    public function PostAddVideoCard(Request $request)
    {	
        if($request->videocart == null ||$request->algoritm == null || $request->numb == null || $request->hash == null){
           return redirect()->route('addvideo');
        }

        debug($request);
        if($request->hash != 5){
            if($request->hash == 4){$request->numb = $request->numb * 1000;}
            if($request->hash == 3){$request->numb = $request->numb * 1000000;}
            if($request->hash == 2){$request->numb = $request->numb * 1000000 * 1000;}
            if($request->hash == 1){$request->numb = $request->numb * 1000000000000;}
        }

        echo $request->numb;
        Hashrate::firstOrCreate(['algoritm_id' => $request->algoritm, 'videocard_id' => $request->videocart, 'userhash' => $request->numb]); 


    	return 1;
    }
}
