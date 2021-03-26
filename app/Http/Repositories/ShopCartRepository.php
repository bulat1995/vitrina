<?php
/*
    Репозиторий корзины пользователя
*/
namespace App\Http\Repositories;

use App\Http\Repositories\CoreRepository;
use App\Models\ShopCart as Model;

class ShopCartRepository extends CoreRepository
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
    }

    protected function getModelClass()
    {
        return Model::class;
    }






    /*
        Продукты находящиеся в корзине пользователя

    */
    public function getCartProducts($user_id=null)
    {
        if(is_null($user_id)){
            return false;
        }
        $columns=array(
            \DB::raw('shop_carts.id as id'),
            'name',
            \DB::raw('price'),
            \DB::raw('quantity'),
            \DB::raw('price* quantity as total_price'),
            \DB::raw('shop_products.id as product_id'),
            \DB::raw('shop_product_photos.path as photo'),
        );

        $result=$this->startConditions()
        ->select($columns)
        ->where('shop_carts.user_id',$user_id)
        ->leftJoin('shop_products',function($join){
            $join->on('shop_products.id','=','shop_carts.product_id');
        })
        ->leftJoin('shop_product_photos',function($join){
            $join->on('shop_products.id','=','shop_product_photos.product_id');
        })
        ->groupBy('shop_carts.product_id')
        ->toBase()
        ->get();

        return $result;
    }



}
