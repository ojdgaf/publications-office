<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Literature extends Model
{
    protected $table = 'literature'; // overriding table name

    protected $searchable = [
        'columns' => [
            'title' => 10,
            'issn' => 9,
            'isbn' => 9,
            'publisher' => 8,
            'issue_year' => 7,
            'size' => 6,
            'type' => 5,
            'description' => 4,
            'periodicity' => 3,
        ],
    ];


    // MUTATOR: ISSN is unique otherwise NULL
    public function setIssnAttribute($value)
    {
    	if ( empty($value) ) {
    		$this->attributes['issn'] = NULL;
    	} else {
        	$this->attributes['issn'] = $value;
    	}
    }

    // MUTATOR: ISBN is unique otherwise NULL
    public function setIsbnAttribute($value)
    {
    	if ( empty($value) ) {
    		$this->attributes['isbn'] = NULL;
    	} else {
        	$this->attributes['isbn'] = $value;
    	}
    }

    public function publications()
    {
        return $this->hasMany('App\Publication');
    }

    public function databases()
    {
        return $this->belongsToMany('App\Database')->withPivot('date');
    }

    // <================================================================================>

    public static function getLiteratureTypes()
    {
        return self::$types;
    }

    public static function getLiteraturePeriodicities()
    {
        return self::$periodicities;
    }

    private static $types = ['journal', 'book', 'conference proceedings'];
    private static $periodicities = [
        ['value' => 12, 'description' => 'Monthly (12 times a year)'],
        ['value' => 6, 'description' => 'Bi-monthly (6 times a year)'],
        ['value' => 4, 'description' => 'Quarterly (4 times a year)'],
        ['value' => 3, 'description' => 'Trianually (3 times a year)'],
        ['value' => 2, 'description' => 'Semiannually (2 times a year)'],
        ['value' => 1, 'description' => 'Annually (1 times a year)'],
    ];
}
