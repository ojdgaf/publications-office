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
        $databaseQuantity = Database::all()->count();

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

            'id_database.*' =>      ['nullable',
                                    'integer',
                                    'distinct',
                                    'between:1,' . $databaseQuantity,
                                    ],

            'date_database.*' =>    ['nullable',
                                    'date',
                                    'after_or_equal:January 01 1990',
                                    'before_or_equal:' . date('F d Y'),
                                    ],

            'cover' =>              ['nullable',
                                    'image',
                                    ],
        ];

        $ids = $this->request->get('id_database');
        $dates = $this->request->get('date_database');

        // id_database[i] and date_database[i] are both NULL or filled
        if (!empty($ids)) {
            foreach ($ids as $key => $value) {
                if (isset($value)) {
                    $rules['date_database.' . $key] =   ['required',
                                                    'date',
                                                    'after_or_equal:January 01 1990',
                                                    'before_or_equal:' . date('F d Y'),
                    ];
                }
            }
        }

        if (!empty($dates)) {
            foreach ($dates as $key => $value) {
                if (isset($value)) {
                    $rules['id_database.' . $key] =     ['required',
                                                        'integer',
                                                        'distinct',
                                                        'between:1,' . $databaseQuantity,
                    ];
                }
            }
        }

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

        for ($i = 0; $i < 5; $i ++) {
            // <======================= id ===============>
            $messages['id_database.' . $i . '.required'] = 'Database #' .
                ($i + 1) . ' name must be chosen';

            $messages['id_database.' . $i . '.integer'] = 'Database #' .
                ($i + 1) . ' name is invalid value';

            $messages['id_database.' . $i . '.distinct'] = 'Database #' .
                ($i + 1) . ' name has one or more duplicates';

            $messages['id_database.' . $i . '.between'] = 'Database #' .
                ($i + 1) . ' must be present in a database';

            // <======================= date =============>
            $messages['date_database.' . $i . '.required'] = 'Database #' .
                ($i + 1) . ' adding date must be chosen';
        }

        return $messages;
    }
}
