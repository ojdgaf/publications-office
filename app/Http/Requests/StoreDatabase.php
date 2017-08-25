<?php

namespace App\Http\Requests;

use App\Database;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDatabase extends FormRequest
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
                                    'between:3,180',
                                    Rule::unique('databases')->ignore($this->database),
                                    ],

            'description' =>        ['nullable',
                                    'string',
                                    'min:10',
                                    ],

            'url' =>                ['nullable',
                                    'string',
                                    'between:3,180',
                                    'url',
                                    Rule::unique('databases')->ignore($this->database),
                                    ],

            'access_mode' =>        ['required',
                                    'string',
                                    Rule::in(Database::getDatabaseAccessModes()),
                                    ],
        ];

        return $rules;
    }
}
