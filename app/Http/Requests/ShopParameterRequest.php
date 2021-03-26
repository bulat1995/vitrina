<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ShopParameter;

class ShopParameterRequest extends FormRequest
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
        //dd($this);
         return [
             'name'=>'required|min:2',
             'regular'=>['required','min:1'],
             'rating'=>['required','min:0'],
             'required'=>'boolean',
             'inputType'=>'required|in:' . implode(',', ShopParameter::inputTypes),
         ];
     }

     public function attributes()
     {
         return [
             'regular'=>'Регулярное выражение'
         ];
     }
}
