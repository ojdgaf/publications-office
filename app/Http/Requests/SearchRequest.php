<?php

namespace App\Http\Requests;

use App\Publication;
use App\Literature;
use App\Author;
use App\Database;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        /* publications and literature types are combined together */
        $types = array_merge(
            Publication::getPublicationTypes(),
            Literature::getLiteratureTypes()
        );

        $rules = [
            /* general rules */
            'query' =>              ['nullable',
                                    'string',
                                    'between:2,20',
                                    ],

            'entity' =>             ['required',
                                    'string',
                                    'in:publication,literature,author,database',
                                    ],

            'type' =>               ['sometimes',
                                    'string',
                                    Rule::in($types),
                                    ],

            'interval' =>           ['sometimes',
                                    'string',
                                    'regex:/^\d{4} - \d{4}$/',
            ],

            /* publication */
            'genre' =>              ['sometimes',
                                    'string',
                                    Rule::in(Publication::getPublicationGenres()),
                                    ],

            'issue_number' =>       ['sometimes',
                                    'integer',
                                    Rule::in(Publication::getPublicationIssueNumbers()),
                                    ],

            /* literature */
            'periodicity' =>        ['sometimes',
                                    'integer',
                                    Rule::in([1,2,3,4,6,12]),
                                    ],

            /* author */
            'status' =>             ['sometimes',
                                    'string',
                                    Rule::in(Author::getAuthorStatuses()),
                                    ],

            'degree' =>             ['sometimes',
                                    'string',
                                    Rule::in(Author::getAuthorDegrees()),
                                    ],

            'rank' =>               ['sometimes',
                                    'string',
                                    Rule::in(Author::getAuthorRanks()),
                                    ],

            /* database */
            'access_mode' =>        ['sometimes',
                                    'string',
                                    Rule::in(Database::getDatabaseAccessModes()),
                                    ],
        ];

        return $rules;
    }
}
