<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Author extends Model
{
    use Eloquence;
    protected $searchableColumns = ['name', 'email'];

	// MUTATOR: email is unique otherwise NULL
    public function setEmailAttribute($value)
    {
    	if ( empty($value) ) {
    		$this->attributes['email'] = NULL;
    	} else {
        	$this->attributes['email'] = $value;
    	}
    }

    public function publications()
    {
        return $this->belongsToMany('App\Publication')->withPivot('status_author');
    }

    public static function filter($parameters = null, $itemsPerPage = 10)
    {
        return self::where($parameters)->orderBy('name')->paginate($itemsPerPage);
    }

    // <================================================================================>

    public static function getAuthorStatuses()
    {
        return self::$statuses;
    }

    public static function getAuthorStudentDegrees()
    {
        return self::$degreesForStudent;
    }

    public static function getAuthorStaffDegrees()
    {
        return self::$degreesForStaff;
    }

    public static function getAuthorDegrees()
    {
        return array_merge(self::$degreesForStudent, self::$degreesForStaff);
    }

    public static function getAuthorRanks()
    {
        return self::$ranks;
    }

    private static $statuses = ['student', 'department staff', 'other'];
    private static $degreesForStudent = ['bachelor', 'master'];
    private static $degreesForStaff = ['candidate of sciences', 'doctor of sciences'];
    private static $ranks = ['docent', 'professor'];
}
