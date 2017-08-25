<?php

namespace App\Http\Requests;

use App\Literature;
use App\Database;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLiterature extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'title' =>              ['required',
                                    'string',
                                    'between:10,150',
                                Rule::unique('literature')->ignore($this->literature),
                                    ],

            'description' =>        ['nullable',
                                    'string',
                                    ],

            'publisher' =>          ['required',
                                    'string',
                                    'between:3,150',
                                    ],

            'type' =>               ['required',
                                    'string',
                                    Rule::in(Literature::getLiteratureTypes()),
                                    ],

            'periodicity' =>        ['required_if:type,journal',
                                    'integer',
                                    Rule::in([1,2,3,4,6,12]),
                                    ],

            'issn' =>               ['sometimes',
                                    'nullable',
                                    'string',
                                    'size:9',
                                    'regex:/^\d{4}-\d{3}[\dxX]$/',
                                    ],

            'size' =>               ['required_if:type,book,type,conference proceedings',
                                    'integer',
                                    'between:1,3000',
                                    ],

            'issue_year' =>         ['required_if:type,book,type,conference proceedings',
                                    'integer',
                                    'between:1990,' . date('Y'),
                                    ],

            'isbn' =>               ['sometimes',
                                    'nullable',
                                    'string',
                                    'between:11,17',
                                    'regex:/^[\-\d]{11,17}$/',
                                    ],

            'databases' =>          ['required',
                                    'array',
                                    'between:1,5',
                                    ],

            'databases.*' =>        ['required',
                                    'array',
                                    'between:1,2',
                                    ],

            'databases.*.database_id' =>    ['nullable',
                                            'required_with:databases.*.date',
                                            'integer',
                                            'distinct',
                                            'exists:databases,id',
                                            ],

            'databases.*.date'=>    ['nullable',
                                    'required_with:databases.*.database_id',
                                    'date',
                                    'after_or_equal:January 01 1990',
                                    'before_or_equal:' . date('F d Y'),
                                    ],

            'cover' =>              ['nullable',
                                    'image',
                                    ],
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [];

        $messages['title.unique'] = 'Such literature already exists in a database';
        $messages['type.in'] = 'Type must be one of following values: ' .
            implode(", ", Literature::getLiteratureTypes());
        $messages['periodicity.in'] = 'Periodicity must be one of following values: ' .
            '1, 2, 3, 4, 6, 12';
        $messages['size.required_if'] = 'Size is required if type is ' .
            'either "Book" or "Conference roceedings"';
        $messages['issue_year.required_if'] = 'Issue year is required if type is ' .
            'either "Book" or "Conference roceedings"';
        $messages['databases.*.date.required_with'] = 'Each database ' .
            'must have corresponding date of adding';
        $messages['databases.*.database_id.required_with'] = 'Empty database name ' .
            'with selected date';
        $messages['databases.*.database_id.distinct'] = 'Databases ' .
            'should not be repeated';
        $messages['databases.*.database_id.exists'] = 'Database(s) ' .
            'must be present in a database';

        return $messages;
    }
}
