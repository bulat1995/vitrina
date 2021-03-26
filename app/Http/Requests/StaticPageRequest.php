<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaticPageRequest extends FormRequest
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
            'title'=>'required|min:3',
            'slug'=>'required|unique:static_pages,slug',
            'category'=>'min:0',
            'rating'=>'required|min:0',
            'in_menu'=>'boolean',
            'content'=>'min:3',
            'describe'=>'min:3',
            'user_show'=>'boolean',
            'can_comment'=>'boolean',
            'can_index'=>'boolean',
        ];
    }
}
