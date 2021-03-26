<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //dd(request());
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
            'name' => ['required', 'string', 'max:255',Rule::unique('users')->ignore($this->route('profile'))],
            'email' => ['required', 'string', 'email', 'max:255',Rule::unique('users')->ignore($this->route('profile'))],
            'firstName' => ['required', 'string', 'max:255'],
            'secondName' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'date'],
            'avatar' => 'image|mimes:jpeg,png,gif,jpg,bmp',
            //'password' => ['required', 'string', 'min:8', 'confirmed']
            'permissionsId'=>['nullable','exists:permissions,id'],
            'roles'=>['required','exists:roles,id'],
        ];
    }

    public function attributes()
    {
        return [
            'roles'=>'Роли',
            'permissionsId'=>'Ключи доступа'
        ];
    }
}
