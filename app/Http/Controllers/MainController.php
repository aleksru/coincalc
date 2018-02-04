<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coin;
use App\Models\Algoritm;
use App\Models\DataCoin;
use App\Models\Hashrate;
use App\Models\Videocard;



class MainController extends Controller
{

    public function index()
    {   
        $msg = '';

        return view('index', ['videocard' => Videocard::all(), 'title' => 'Главная', 'algoritm' => Algoritm::all(), 'msg' => $msg]);
    }
    
    public function postindex(Request $request)
    {

        debug($request);

        $finnalyUserHash;
        $finallyAlgoritm;

        if(isset($request->videocart)){
            $gethash = Videocard::find($request->videocart);
        }

        if(isset($request->algoritm)){
            $finallyAlgoritm = Algoritm::find($request->algoritm)->id;
        }

        if(isset($request->numb)&&isset($request->hash)){
            $finnalyUserHash = $this->math($request->numb, $request->hash);
        }

        if(!empty($finnalyUserHash)&&!empty($finallyAlgoritm)){
            return $this->summary($finnalyUserHash, $finallyAlgoritm);
        }

        if(!empty($gethash)){
            if(!empty($finallyAlgoritm)){
                $hashrate = Hashrate::where('videocard_id', $gethash->id)->where('algoritm_id', $finallyAlgoritm)->get();
                if(!isset($hashrate[0])){
                    return 1;
                }
                return $this->summary($hashrate[0]->userhash, $finallyAlgoritm);
            }

            foreach($gethash->hashrates as $rate){
                echo '<h1>'.$rate->name.'</h1>'.'<br>'; 
                $this->summary(!empty($finnalyUserHash)?$finnalyUserHash:$rate->pivot->userhash, $rate->id);
            }
        }

        return 1;
    }



    public function math($hash, $numb)
    {
    	// $b = (23.3*1e6)/(1.7856257368148E+14);
    	// $h = 3600 / 14.3602;
    	// $res1 = 2.91*$b*$h*24;
    	// $res1 = round($res1, 4);

        if($numb != 5){
            if($numb == 4){$request->numb = $request->numb * 1000;}
            if($numb == 3){$hash = $hash * 1000000;}
            if($numb == 2){$hash = $hash * 1000000 * 1000;}
            if($numb == 1){$hash = $hash * 1000000000000;}
        }
    	return $hash;
    }


    public function summary($userhash, $algoritm_id)
    {	
 
    	$arr = Algoritm::find($algoritm_id)->coin;

    	foreach($arr as $key){
    		$b = ($userhash)/($key->datacoin->nethash);
	    	$h = 3600 / $key->datacoin->block_time;
	    	$res1 = $key->datacoin->block_reward *$b*$h*24;
	    	$res1 = round($res1, 5);
	    	echo $key->datacoin->coin->name.' '.$res1.'<br>';

    	}



    	return 1;
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
    	$allaltm = Algoritm::all();
    	
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
