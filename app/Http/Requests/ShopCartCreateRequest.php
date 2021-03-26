<?php
/*
    Корзина пользователя

*/
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShopCartCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity'=>'required|min:1|integer',
            'product_id'=>['required','exists:shop_products,id',Rule::unique('shop_carts')->where(function ($query) {
              $query->where('product_id', request()->input('product_id'));
              $query->where('user_id', auth()->user()->id);
            })],
        ];
    }
}
