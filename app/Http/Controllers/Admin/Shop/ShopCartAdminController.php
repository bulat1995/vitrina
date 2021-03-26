<?php

namespace App\Http\Controllers\Admin\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ShopCart;

class ShopCartAdminController extends Controller
{
    /**
     * Вывод корзинок пользователей по количеству заказов
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns=[
            \DB::raw('shop_products.name as name'),
            \DB::raw('shop_products.id as id'),
            \DB::raw('SUM(quantity) as quantity'),
        ];

        $carts=ShopCart::select($columns)
            ->leftJoin('shop_products',function($join){
                $join->on('shop_products.id','=','shop_carts.product_id');
            })->
            groupBy('product_id')->
            orderBy('quantity','DESC')->
            paginate(20);
        return view('admin.shop.cart.index',compact('carts'));
    }

}
