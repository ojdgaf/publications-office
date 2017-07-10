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
                                    /* 'regex:/^((https?|ftp):\/\/)?([a-z0-9+!*(),;?&=.-]+(:[a-z0-9+!*(),;?&=.-]+)?@)?([a-z0-9\-\.]*)\.(([a-z]{2,4})|([0-9]{1,3}\.([0-9]{1,3})\.([0-9]{1,3})))(:[0-9]{2,5})?(\/([a-z0-9+%-]\.?)+)*\/?(\?[a-z+&$_.-][a-z0-9;:@&%=+\/.-]*)?(#[a-z_.-][a-z0-9+$%_.-]*)?$/',
                                    */
                                    ],

            'access_mode' =>        ['required',
                                    'string',
                                    Rule::in(Database::getDatabaseAccessModes()),
                                    ],
        ];

        return $rules;
    }
}
