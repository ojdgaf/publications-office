<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatabaseLiterature extends Model
{
    protected $table = 'database_literature'; // overriding table name

    protected $fillable = [
        'database_id', 'literature_id', 'date'
    ];
}
