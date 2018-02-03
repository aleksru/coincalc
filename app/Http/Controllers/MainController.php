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
        $gethash = Videocard::find($request->videocart);
        if(isset($request->algoritm)){
            $alg = Algoritm::find($request->algoritm);
            $hash = Hashrate::where('videocard_id', $gethash->id)->where('algoritm_id', $alg->id)->get();
            if(!isset($hash[0])){
                return 1;
            }
            return $this->summary($hash[0]->userhash, $alg->id);
        }
        debug($gethash);

        foreach($gethash->hashrates as $rate){
            //echo $rate->pivot->userhash.'<br>';
            echo '<h1>'.$rate->name.'</h1>'.'<br>';
            debug($rate);
            $this->summary($rate->pivot->userhash, $rate->id);
        }


        return 1;
    }



    public function math()
    {
    	// $b = (23.3*1e6)/(1.7856257368148E+14);
    	// $h = 3600 / 14.3602;
    	// $res1 = 2.91*$b*$h*24;
    	// $res1 = round($res1, 4);

    	$b = (550)/(50287158);
    	$h = 3600 / 511;
    	$res1 = 12.5*$b*$h*24;
    	$res1 = round($res1, 7);
    	return $res1;
    }


    public function summary($userhash, $algoritm_id)
    {	
    	$arr = Algoritm::find($algoritm_id)->coin;
    	debug($arr);
    	//echo Algoritm::find($algoritm_id)->name.'<br>'.'<br>';
    	//echo 'userhash '.$userhash.'<br>'.'<br>';

    	foreach($arr as $key){
    		//dump($key->datacoin);
    		$b = ($userhash)/($key->datacoin->nethash);
	    	$h = 3600 / $key->datacoin->block_time;
	    	$res1 = $key->datacoin->block_reward *$b*$h*24;
	    	$res1 = round($res1, 5);
            //debug($key->datacoin->coin->name);
	    	echo $key->datacoin->coin->name.' '.$res1.'<br>';
	    	//debug($key->datacoin->coin->name);
	    	//debug(Coin::find(119)->datacoin);
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
        Hashrate::create(['algoritm_id' => $request->algoritm, 'videocard_id' => $request->videocart, 'userhash' => $request->numb]); 


    	return 1;
    }
}
