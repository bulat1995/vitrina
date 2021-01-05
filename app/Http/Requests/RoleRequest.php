<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
            'slug'=>['required','min:3',Rule::unique('roles')->ignore($this->route('role'))],
            'permissionsId'=>'required|exists:permissions,id'
        ];
    }

    public function messages()
    {
        return [
                'name.required'=>'Поле ":attribute" обязательно для заполнения',
                'slug.required'=>'Поле ":attribute" обязательно для заполнения',
                'slug.unique'=>'Поле ":attribute" с таким значением уже существует',
                'permissionsId.required'=>'Поле ":attribute" обязательно для заполнения',
                'permissionsId.exists'=>'Значения поля ":attribute" должны существовать в системе',
        ];
    }

    public function attributes()
    {
        return [
            'name'=>'Наименование роли',
            'slug'=>'Идентификатор роли',
            'permissionsId'=>'Ключи доступа'
        ];
    }
}
