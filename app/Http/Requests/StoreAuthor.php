<?php

namespace App\Http\Requests;

use App\Author;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAuthor extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' =>               ['required',
                                    'string',
                                    'regex:/^[A-Za-z\s\'\.,-]{5,50}$/',
                                    ],

            'email' =>              ['nullable',
                                    'string',
                'regex: /^([a-z0-9_\.\+-]{2,32})@([\da-z\.-]{2,10})\.([a-z\.]{2,6})$/',
                            Rule::unique('authors')->ignore($this->author),
                                    ],

            'status' =>             ['required',
                                    'string',
                                    Rule::in(Author::getAuthorStatuses()),
                                    ],

            'rank' =>               ['required_if:status,department staff',
                                    'string',
                                    Rule::in(Author::getAuthorRanks()),
                                    ],

            'post' =>               ['required_if:status,department staff',
                                    'string',
                                    'regex:/^[A-Za-z\s\'\.,-]{3,100}$/',
                                    ],
        ];

        if ($this->request->get('status') == 'student') {
            $rules['degree'] =      ['required',
                                    'string',
                                    Rule::in(Author::getAuthorStudentDegrees()),
            ];
        }

        if ($this->request->get('status') == 'department staff') {
            $rules['degree'] =      ['required',
                                    'string',
                                    Rule::in(Author::getAuthorStaffDegrees()),
            ];
        }

        return $rules;
    }
}
