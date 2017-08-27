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
        $type =             $this->request->get('type');
        $literatureId =     $this->request->get('literature_id');
        $pageInitial =      $this->request->get('page_initial');
        $pageFinalLimit =   Literature::withTrashed()->find($literatureId)->size;

        $rules = [
            'heading' =>            ['required',
                                    'string',
                                    'between:10,180',
                                    Rule::unique('publications')
                                        ->ignore($this->publication),
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

            'authors' =>            ['required',
                                    'array',
                                    'between:1,5',
                                    ],

            'authors.*' =>          ['required',
                                    'array',
                                    'size:2',
                                    ],

            'authors.*.author_id' =>    ['required',
                                        'integer',
                                        'distinct',
                                        'exists:authors,id',
                                        ],

            'authors.*.status_author'=> ['required',
                                        'string',
                                        Rule::in(Author::getAuthorStatuses()),
                                        ],

            'type' =>               ['required',
                                    'string',
                                    Rule::in(Publication::getpublicationTypes()),
                                    ],

            'literature_id' =>      ['required',
                                    'integer',
                                    'exists:literature,id',
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
                                        'between:' .
                                            $pageInitial . ',' . $pageFinalLimit,
                                        ];
        }

        // updating a publication file is not necessary
        if ($this->publication) {
            $rules['document'] = ['file', 'mimes:doc,docx,pdf,odt,txt'];
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
        $messages['literature_id.exists'] = 'Literature must be present in a database';
        $messages['issue_number.required_if'] = 'Issue number' .
            'is required if type is "Journal article"';
        $messages['issue_number.in'] = 'Issue number is a number from 1 to 12';
        $messages['issue_year.required_if'] = 'Issue year' .
            'is required if type is "Journal article"';
        $messages['page_initial.required'] = 'Initial page is required';
        $messages['page_initial.between'] = 'Initial page' .
            'should be in a range between 1 and size of literature';
        $messages['page_final.required'] = 'Final page is required';
        $messages['page_final.between'] = 'Final page should be in a range between ' .
            'initial page and size of literature';
        $messages['document.mimes'] = 'Uploaded publication document' .
            'must have one of following extensions: .DOC, .DOCX, .PDF, .TXT, .ODT';
        $messages['authors.*.status_author.in'] = 'Author\'s status' .
            'must be one of following values: ' . implode(", ", Author::getAuthorStatuses());
        $messages['authors.*.author_id.distinct'] = 'Authors ' .
            'should not be repeated';
        $messages['authors.*.author_id.exists'] = 'Author(s) ' .
            'must be present in a database';

        return $messages;
    }
}
