<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Videocard extends Model
{
    public function hashrates()
    {
        return $this->belongsToMany('App\Models\Algoritm', 'hashrates')->withPivot('userhash');
    }
}
