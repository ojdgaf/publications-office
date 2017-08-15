<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $fillable = [
        'heading', 'abstract', 'description',
        'genre', 'type', 'literature_id',
        'issue_number', 'issue_year', 'page_initial',
        'page_final', 'document_path',
    ];

    protected $searchable = [
        'columns' => [
            'heading' => 10,
            'description' => 9,
            'abstract' => 8,
            'genre' => 7,
            'type' => 6,
            'issue_number' => 5,
            'issue_year' => 5,
            'page_initial' => 4,
            'page_final' => 4,
        ],
    ];

    public function literature()
    {
        return $this->belongsTo('App\Literature');
    }

    public function authors()
    {
        return $this->belongsToMany('App\Author')->withPivot('status_author');
    }

    public static function filterWithJoin($parameters = null, $itemsPerPage = 10)
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
            ->orderBy('heading')
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
