<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Videocard;
use App\Models\Algoritm;
use App\Http\Controllers\PriceController;
use App\Models\Coin;
use App\Models\Hashrate;



class MainController extends Controller
{
    protected $price_btc;

    public function __construct()
    {
        $this->price_btc = Coin::where('tag', 'BTC')->get()[0]->price[0]->Last;
    }

    public function index()
    {
        $msg = '';
        $AlgEnc = DB::table('algoritms')->join('encryptrates', 'algoritms.encryptrate_id', '=', 'encryptrates.id')->select('algoritms.name as algname','algoritms.id as algid','encryptrates.id as encid' ,'encryptrates.name as encname')->get();

        return view('index', ['videocard' => Videocard::all(), 'title' => 'Главная', 'algoritm' => $AlgEnc, 'msg' => $msg]);
    }
    
    public function postindex(Request $request){

        $price_btc = $this->price_btc;
        $allCol = [];

        foreach ($request->all() as $key => $value) {
           if(substr($key, 0, 6) == 'algenc' && !empty($value)){
                $key = explode("/", $key);
                //dump($this->summary($this->math($value, $key[2]), $key[1]));
                foreach ($this->summary($this->math($value, $key[2]), $key[1]) as $name => $value){
                    $allCol[] = collect([
                        'coin'=>$name,
                        'rate' => $value[0],
                        'encrypt'=> Algoritm::find($key[1])->name,
                        'last_max_price' => $this->RecorsionByNull($value[1]->getLastPrices()->max()),
                        'avg_price' => $this->RecorsionByNull($this->RecorsionBcint($value[1]->getAvgPrices())), 
                        'avg_profit' => round($value[2]*$value[1]->getAvgPrices()*$price_btc, 2), 
                        'max_24_profit' => round($value[1]->getOneMaxPrice()*$value[0]*$price_btc, 2), 
                        'max_last_profit' => round($value[1]->getLastPrices()->max()*$value[0]*$price_btc, 2),
                        'max_last_profit_market'=> $value[1]->getLastPrices()->search($value[1]->getLastPrices()->max(), true)
                    ]);
                }             
           }
        }

        $allCol = collect($allCol)->reject(function ($value, $key){
            return !$value['max_24_profit'] && !$value['avg_profit'];
            })->sortByDesc(function ($value, $key) {
                            return $value->get('max_last_profit');
                        });
        //return 1;
        return $allCol = $allCol->toArray();  
    }

    public function ajax(Request $request)
    {   

        return view('table', ['results' => $this->postindex($request)]);
    }

    public function PostGetHashAjax(Request $request)
    {

        $res = [];
        foreach ($request->all() as $key => $value) {
            if($value && $value != 0){
                $getRates = Videocard::find($key)->hashrates;
                foreach ($getRates as $rate) {
                    if(!array_key_exists($rate->id, $res)){
                        $res[$rate->id] = round($this->math($rate->pivot->userhash, $rate->encryptrate_id, $reverse = True), 2)*$value;
                    }else{
                        $res[$rate->id] = $res[$rate->id] + round($this->math($rate->pivot->userhash, $rate->encryptrate_id, $reverse = True), 2)*$value;
                    }
                }
            }
        }


        return $res;
    }
    
    public function RecorsionByNull($int)
    {   
        if($int[strlen($int) - 1] == '0'){
            //echo $int.'<br>';
            $int = substr($int, 0, -1);
            return $this->RecorsionByNull($int);
        }else{
            return $int;
        }
    }

    public function RecorsionBcint($int)
    {   
        return sprintf("%.9f", $int);
    }


    public function math($hash, $numb, $reverse = False)
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
            if($numb == 4){
                if(!$reverse){
                    $hash = $hash * 1000;
                }else{
                    $hash = $hash / 1000;
                }
                
            }
            if($numb == 3){
                if(!$reverse){
                    $hash = $hash * 1000000;
                }else{
                    $hash = $hash / 1000000;
                }
            }
            if($numb == 2){
                if(!$reverse){
                    $hash = $hash * 1000000 * 1000;
                }else{
                    $hash = $hash / (1000000 * 1000);
                }
            }
            if($numb == 1){
                if(!$reverse){
                    $hash = $hash * 1000000000000;
                }else{
                    $hash = $hash / 1000000000000;
                }
            }
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

            if(time() <= idate('U', strtotime($key->datacoin->updated_at))+3600){
                $priceCoin = (new PriceController($key));
                $result[$key->datacoin->coin->name] = [round($key->datacoin->block_reward *$b*$h*24, 5), $priceCoin, 
                                                        round($key->datacoin->block_reward24 *$b*$h*24, 5)];
            }
            
    	}



    	return $result;
    }



    public function GetAddVideoCard($msg = '')
    {	
        $AlgEnc = DB::table('algoritms')->join('encryptrates', 'algoritms.encryptrate_id', '=', 'encryptrates.id')->select('algoritms.name as algname','algoritms.id as algid','encryptrates.id as encid' ,'encryptrates.name as encname')->get();

    	return view('addvideocart', ['videocard' => Videocard::all(), 'title' => 'Add', 'algoritm' => $AlgEnc, 'msg' => $msg]);
    }

/*
1 MH/s = 1,000 kH/s = 1,000,000 H/s
1 GH/s = 1,000 MH/s = 1,000,000 kH/s
1 TH/s = 1,000 GH/s = 1,000,000 MH/s = 1,000,000,000 kH/s = 1,000,000,000,000 H/s
*/


    public function PostAddVideoCard(Request $request)
    {	
        if($request->videocart == null){
           return redirect()->route('addvideo');
        }
        foreach ($request->all() as $key => $value){
            if(substr($key, 0, 6) == 'algenc' && !empty($value)){
                $key = explode("/", $key);
                Hashrate::firstOrCreate(['algoritm_id' => $key[1], 'videocard_id' => $request->videocart, 'userhash' => $this->math($value, $key[2])]);
            }
        }

        return redirect()->route('addvideo')->with('msg','OK');
    }
}
