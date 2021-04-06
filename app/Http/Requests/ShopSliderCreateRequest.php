<?php
/*
    Проверка данных формы при создании
    слайдера

*/
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopSliderCreateRequest extends FormRequest
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
            'category'=>'',
            'title'=>'required|string',
            'describe'=>'required|string',
            'image'=>'required|mimes:gif,png,jpg',
            'buttonText'=>'required|string',
            'href'=>'required',
            'blank'=>'boolean',
            'show'=>'boolean',
            'rating'=>'integer',
            'showUntil'=>'datetime|nullable',
        ];
    }


    public function attributes()
    {
        return [
                'describe'=>'Описание',
                'image'=>'Изображение',
                'buttonText'=>'Надпись на кнопки',
                'href'=>'Ссылка на кнопке',
                'image'=>'Изображение',
        ];
    }
}
