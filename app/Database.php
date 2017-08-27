<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Database extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'url',
        'access_mode'
    ];

    protected $searchable = [
        'columns' => [
            'name' => 10,
            'description' => 9,
            'url' => 8,
            'access_mode' => 7,
        ],
    ];

    protected $dates = ['deleted_at'];

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

    public function remove()
    {
        $this->literature->isEmpty() ? $this->forceDelete() : $this->delete();
    }

    // <================================================================================>

    public static function getDatabaseAccessModes()
    {
        return self::$accessModes;
    }

    private static $accessModes = ['Subscription', 'Subscription; Limited free access with registration', 'Free', 'Free and Subscription', 'Free abstracts; Subscription full-text', 'Free abstract and preview; Subscription full-text', 'Free searching; Subscription full-text', 'Free online searching; offline use by subscription', 'N/A'];
}
