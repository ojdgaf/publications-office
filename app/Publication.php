<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// <====================================================================================>

class Publication extends Model
{
    public function literature()
    {
        return $this->belongsTo('App\Literature');
    }

    public function authors()
    {
        return $this->belongsToMany('App\Author')->withPivot('status_author');
    }

    public static function filter($parameters = null, $itemsPerPage = 10)
    {
        return self::
            join(
                'author_publication', 
                'publications.id', '=', 'author_publication.publication_id'
            )
            ->select(
                'publications.*',
                'author_publication.author_id'
            )
            ->where($parameters)
            ->select('publications.*')
            ->distinct()
            ->paginate($itemsPerPage);
    }

    // <================================================================================>

    public static function getPublicationIssueNumbers() 
    {
    	return self::$issueNumbers;
    }

    public static function getPublicationTypes() 
    {
        return self::$types;
    }

    public static function getPublicationGenres() 
    {
        return self::$genres;
    }

    public static function getPublicationExtensions() 
    {
        return self::$extensions;
    }

    private static $issueNumbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    private static $types = ['journal article', 'book article', 'report of conference'];
    private static $genres = ['book review', 'case report', 'article commentary', 'commentary', 'rapid communication', 'concept paper', 'correction', 'creative', 'data descriptor', 'discussion', 'editorial', 'erratum', 'essay', 'expression of concern', 'interesting image', 'letter', 'books received', 'obituary', 'opinion', 'project report', 'reply', 'retraction', 'review article', 'note', 'technical note'
    ];
    private static $extensions = ['doc', 'docx', 'pdf', 'txt', 'odt'];
}
