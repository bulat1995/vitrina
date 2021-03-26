<?php
/*
    Репозиторий отзывов о товаре
*/
namespace App\Http\Repositories;

use App\Http\Repositories\CoreRepository;
use App\Models\Review as Model;

class ReviewRepository extends CoreRepository
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
        Отзывы конкретного пользователя

    */
    public function getReviewsByUser($user_id=null)
    {
        if(is_null($user_id)){
            return false;
        }
        $columns=array(
            'name',
            'review',
            'estimate',
            'checked',
            \DB::raw('reviews.id as id'),
            \DB::raw('reviews.product_id as product_id'),
            \DB::raw('shop_product_photos.path as photo'),
        );

        $result=$this->startConditions()
        ->select($columns)
        ->leftJoin('shop_products',function($join){
            $join->on('shop_products.id','=','reviews.product_id');
        })
        ->leftJoin('shop_product_photos',function($join){
            $join->on('shop_products.id','=','shop_product_photos.product_id');
        })
        ->where('user_id',$user_id)
        ->groupBy('reviews.product_id')
        ->toBase()
        ->paginate(20);
        return $result;
    }


    /*
        Отзывы конкретного товара

    */
    public function getReviewsByProduct($product_id=null)
    {
        if(is_null($product_id)){
            return false;
        }

        $columns=array(
            'name',
            'review',
            'estimate',
            'checked',
            \DB::raw('users.name as username'),
            \DB::raw('users.avatar as avatar'),
        );

        $result=$this->startConditions()
        ->select($columns)
        ->leftJoin('users',function($join){
            $join->on('users.id','=','reviews.user_id');
        })
        ->where('product_id',$product_id)
        ->where('checked',true)
        ->toBase()
        ->paginate(20);
        return $result;
    }


    /*
        Вывод непроверенных отзывов
    */
    public function getReviewsNotChecked(){
        $columns=array(
             \DB::raw('reviews.id as id'),
            'review',
            'estimate',
            'price',
            \DB::raw('shop_products.id as product_id'),
            \DB::raw('shop_products.name as product_name'),
            \DB::raw('shop_product_photos.path as photo'),
            \DB::raw('users.name as username'),
            \DB::raw('users.id as user_id'),
            \DB::raw('users.avatar as avatar'),
        );

        $result=$this->startConditions()
        ->select($columns)
        ->leftJoin('shop_products',function($join){
            $join->on('shop_products.id','=','reviews.product_id');
        })
        ->leftJoin('shop_product_photos',function($join){
            $join->on('shop_products.id','=','shop_product_photos.product_id');
        })
        ->leftJoin('users',function($join){
            $join->on('users.id','=','reviews.user_id');
        })

        ->where('checked',false)
        ->groupBy('reviews.id')
        ->toBase()
        ->paginate(20);
        return $result;
    }


    /*
        Вывод отзыва по его идентфикатору
    */
    public function getReviewById($id)
    {
        $columns=array(
             \DB::raw('reviews.id as id'),
            'review',
            'estimate',
            'price',
            \DB::raw('reviews.created_at as created_at'),
            \DB::raw('reviews.updated_at as updated_at'),
            \DB::raw('shop_products.id as product_id'),
            \DB::raw('shop_products.name as product_name'),
            \DB::raw('shop_product_photos.path as photo'),
            \DB::raw('users.name as username'),
            \DB::raw('users.id as user_id'),
            \DB::raw('users.avatar as avatar'),
        );

        $result=$this->startConditions()
        ->select($columns)
        ->leftJoin('shop_products',function($join){
            $join->on('shop_products.id','=','reviews.product_id');
        })
        ->leftJoin('shop_product_photos',function($join){
            $join->on('shop_products.id','=','shop_product_photos.product_id');
        })
        ->leftJoin('users',function($join){
            $join->on('users.id','=','reviews.user_id');
        })

        ->where('reviews.id',$id)
        ->groupBy('reviews.id')
        ->first();
        return $result;

    }

}
