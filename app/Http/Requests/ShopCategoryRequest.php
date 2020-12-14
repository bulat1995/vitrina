<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopCategoryRequest extends FormRequest
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
            'parent_id'=>'required|min:0',
            'is_public'=>'boolean',
            'logo'=>'image|mimes:jpeg,png,gif,jpg,bmp|max:4096'
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Поле ":attribute" обязательно для заполнения',
            'name.min'=>'Минимальная длина поля ":attribute": :min символа ',
            'parent_id.exists'=>'Неверно указана категория',
            'logo.mimes'=>'Формат файла должен соответствовать изображению '
        ];
    }


    public function attributes()
    {
        return [
            'name' => 'Наименование категории',
            'parent' => 'Родитель',
        ];
    }
}
