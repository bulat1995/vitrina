<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionRequest extends FormRequest
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
            'name'=>'required|min:2',
            'action_name'=>'required|min:2',
            'slug'=>['required','min:3',  Rule::unique('permissions')->ignore($this->route('permission'))],
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Поле ":attribute" обязательно для заполнения',
            'name.min'=>'Минимальная длина поля ":attribute"  :min символа',
            'slug.required'=>'Поле ":attribute" обязательно для заполнения',
            'slug.unique'=>'Поле ":attribute" с таким значением уже существует'
        ];
    }

    public function attributes()
    {
        return [
            'name'=>'Наименование права',
            'slug'=>'Ключ доступа к действию'
        ];
    }
}
