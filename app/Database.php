<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Database extends Model
{
    // MUTATOR: URL is unique otherwise NULL
    public function setUrlAttribute($value)
    {
    	if ( empty($value) ) {
    		$this->attributes['url'] = NULL;
    	} else {
        	$this->attributes['url'] = $value;
    	}
    }

    public function literature()
    {
        return $this->belongsToMany('App\Literature')->withPivot('date');
    }

    // <================================================================================>
}
