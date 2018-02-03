<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hashrate extends Model
{
    protected $fillable = ['algoritm_id', 'videocard_id', 'userhash'];
    public $timestamps = false;
}
