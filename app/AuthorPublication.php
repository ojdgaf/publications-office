<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthorPublication extends Model
{
    protected $table = 'author_publication'; // overriding table name

    protected $fillable = ['author_id', 'publication_id', 'status_author'];
}
