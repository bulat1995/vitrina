<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShopReviewCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'review'=>'required|min:1',
            'estimate'=>'required|integer|min:1',
            'product_id'=>['required','exists:shop_products,id',Rule::unique('reviews')->where(function($query){
                $query->where('user_id',auth()->user()->id);
                $query->where('product_id',request()->input('product_id'));
            })],
        ];
    }
}
