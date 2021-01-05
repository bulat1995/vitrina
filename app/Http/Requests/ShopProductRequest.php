<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ShopProductParameterRule;

class ShopProductRequest extends FormRequest
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
            'name'=>'required|min:3',
            'price'=>'required|gt:0',
            'images.*'=>'mimes:jpeg,png,gif,jpg,bmp|max:4096',
            //'category_id'=>'required|exists:shop_categories,id',
            'param'=>[new ShopProductParameterRule],
        ];
    }
}
