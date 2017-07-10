<?php

namespace App\Http\Requests;

use App\Publication;
use App\Author;
use App\Literature;
use Validator;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class StorePublication extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // getting values
        $type =                     $this->request->get('type');
        $literatureId =             $this->request->get('literature_id');
        $pageInitial =              $this->request->get('page_initial');
        $ids =                      $this->request->get('id_author');
        $statuses =                 $this->request->get('status_author');

        $authorMaxId = Author::max('id');
        $literatureMaxId = Literature::max('id');

        $pageFinalLimit = Literature::find($literatureId)->size;

        $rules = [
            'heading' =>            ['required',
                                    'string',
                                    'between:10,180',
                                    Rule::unique('publications')->ignore($this->publication),
                                    ],

            'abstract' =>           ['required',
                                    'string',
                                    'min:10',
                                    ],

            'description' =>        ['required',
                                    'string',
                                    'min:10',
                                    ],

            'genre' =>              ['required',
                                    'string',
                                    Rule::in(Publication::getPublicationGenres()),
                                    ],

            // at least one author
            'id_author' =>          ['required',
                                    'array',
                                    ],

            'status_author' =>      ['required',
                                    'array',
                                    ],

            'id_author.*' =>        ['required',
                                    'integer',
                                    'distinct',
                                    'between:1,' . $authorMaxId,
                                    ],

            'status_author.*' =>    ['required',
                                    'string',
                                    Rule::in(Author::getAuthorStatuses()),
                                    ],

            'type' =>               ['required',
                                    'string',
                                    Rule::in(Publication::getpublicationTypes()),
                                    ],

            'literature_id' =>      ['required',
                                    'integer',
                                    'between:1,' . $literatureMaxId,
                                    ],

            'issue_number' =>       ['required_if:type,journal article',
                                    'integer',
                                    Rule::in(Publication::getPublicationIssueNumbers()),
                                    ],

            'issue_year' =>         ['required_if:type,journal article',
                                    'integer',
                                    'between:1990,' . date('Y'),
                                    ],

            'page_initial' =>       ['required',
                                    'integer',
                                    'between:1,1000',
                                    ],

            'page_final' =>         ['required',
                                    'integer',
                                    'between:' . $pageInitial . ',1000',
                                    ],

            'document' =>           ['required',
                                    'file',
                                    'mimes:doc,docx,pdf,odt,txt',
                                    ],
        ];

        // publication range should not be out of literature size
        if ($type == 'book article' || $type == 'report of conference') {
            $rules['page_initial'] =    ['required',
                                        'integer',
                                        'between:1,' . $pageFinalLimit,
                                        ];

            $rules['page_final'] =      ['required',
                                        'integer',
                                        'between:' . $pageInitial . ',' . $pageFinalLimit,
                                        ];
        }

        // updating a publication file is not necessary
        if ($this->publication) {
            $rules['document'] = ['file', 'mimes:doc,docx,pdf,odt,txt'];
        }

        // <======================= fetch the first five elements ===========>
        if (count($ids) > 5) {
            $ids = array_slice($ids, 0, 5);
        }

        if (count($statuses) > 5) {
            $statuses = array_slice($statuses, 0, 5);
        }

        // <======================= set relative requirements ===============>
        if ( !empty($ids) ) {
            foreach ($ids as $key => $value) {
                /*
                *  id_author[i] <-> status_author[i]
                *        \\                 \\
                *       value               null
                */
                if ( isset($value) && !isset($statuses[$key]) ) {
                    $rules['status_author.' . $key] =   ['required',
                                                        'string',
                                                Rule::in(Author::getAuthorStatuses()),
                                                        ];
                }
            }
        }

        if ( !empty($statuses) ) {
            foreach ($statuses as $key => $value) {
                /*
                *  id_author[i] <-> status_author[i]
                *        \\                 \\
                *       null               value
                */
                if ( isset($value) && !isset($ids[$key]) ) {
                    $rules['id_author.' . $key] =       ['required',
                                                        'integer',
                                                        'distinct',
                                                        'between:1,' . $authorMaxId,
                                                        ];
                }
            }
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [];

        $messages['heading.unique'] = 'This publication already exists in a database';
        $messages['id_author.required'] = 'At least one author should be added';
        $messages['status_author.required'] = 'Status is required for each author';
        $messages['genre.in'] = 'Genre is invalid value';
        $messages['type.in'] = 'Type must be one of following values: ' .
            implode(", ", Publication::getpublicationTypes());
        $messages['literature_id.between'] = 'Literature must be present in a database';
        $messages['issue_number.required_if'] = 'Issue number is required if type is ' .
            '"Journal article"';
        $messages['issue_number.in'] = 'Issue number is a number from 1 to 12';
        $messages['issue_year.required_if'] = 'Issue year is required if type is "Journal article"';
        $messages['page_initial.required'] = 'Initial page is required';
        $messages['page_initial.between'] = 'Initial page should be in a range between ' . '1 and size of literature';
        $messages['page_final.required'] = 'Final page is required';
        $messages['page_final.between'] = 'Final page should be in a range between ' .
            'initial page and size of literature';
        $messages['document.mimes'] = 'Uploaded publication document must have one of following extensions: .DOC, .DOCX, .PDF, .TXT, .ODT';

        for ($i = 0; $i < 5; $i ++) {
            // <======================= id ===============>
            $messages['id_author.' . $i . '.required'] = 'Author #' .
                ($i + 1) . ' name must be chosen';

            $messages['id_author.' . $i . '.integer'] = 'Author #' .
                ($i + 1) . ' name is invalid value';

            $messages['id_author.' . $i . '.distinct'] = 'Author #' .
                ($i + 1) . ' name has one or more duplicates';

            $messages['id_author.' . $i . '.between'] = 'Author #' .
                ($i + 1) . ' must be present in a database';

            // <======================= status ============>
            $messages['status_author.' . $i . '.required'] = 'Author #' .
                ($i + 1) . ' status must be chosen';

            $messages['status_author.' . $i . '.string'] = 'Author #' .
                ($i + 1) . ' status is invalid value';

            $messages['status_author.' . $i . '.in'] = 'Author #' .
                ($i + 1) . ' status must be one of following values: ' .
                implode(", ", Author::getAuthorStatuses());
        }

        return $messages;
    }
}
