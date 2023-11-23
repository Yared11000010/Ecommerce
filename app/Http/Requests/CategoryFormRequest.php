<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            
          
            'group_id'=>[
                'required',
                'string'
            ],
            'name'=>[
                'required',
                'string'
            ],
            'image'=>[
                    'image',
                    'nullable',
                    'mimes:png,jpg,jpeg'
                ],
            'discount'=>[
                'required',
                'integer'
            ],
            'description'=>[
                'required',
                'string'
            ],
            'url'=>[
                'required',
                'string'
            ],
            'meta_title'=>[
                'required',
                'string'
            ],
            'meta_description'=>[
                'required',
                'string'
            ],
            'meta_keywords'=>[
                'required',
                'string'
            ],
            'status'=>[
                'nullable'
            ]
        ];
    }
}
