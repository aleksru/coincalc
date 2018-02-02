<?php

namespace App\Http\Controllers\UploadData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseDataController extends Controller
{
    protected function DownloanJson($url)
    {

        $j = file_get_contents($url);
        $j = json_decode($j, true);
        //debug($j);

        return $j;
    }
}
