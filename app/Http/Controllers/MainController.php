<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coin;
use App\Models\Algoritm;
use App\Models\DataCoin;

class MainController extends Controller
{
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


    public function summary($userhash = 550)
    {	
    	$arr = Algoritm::find(9)->coin;
    	debug($arr);
    	echo Algoritm::find(9)->name.'<br>'.'<br>';
    	echo 'userhash '.$userhash.'<br>'.'<br>';

    	foreach($arr as $key){
    		//dump($key->datacoin);
    		$b = ($userhash)/($key->datacoin->nethash);
	    	$h = 3600 / $key->datacoin->block_time;
	    	$res1 = $key->datacoin->block_reward *$b*$h*24;
	    	$res1 = round($res1, 5);
	    	echo $key->datacoin->coin->name.' '.$res1.'<br>';
	    	debug($key->datacoin->coin->name);
	    	//debug(Coin::find(119)->datacoin);
    	}



    	return 1;
    }
}
