<?php
namespace App\Http\Repositories;

use App\Http\Repositories\CoreRepository;
use App\Models\ShopProduct as Model;

class ShopProductRepository extends CoreRepository
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
        Получить информацию о продукте
        по идентификаторам категории и товара
    */
    public function getProductDetailById($product_id,$category_id=0)
    {
        $columns=[
            'shop_parameters.id',
            'value',
            'shop_parameters.name',
            'shop_parameters.regular',
            'shop_parameters.inputType',
            'shop_parameters.required',
        ];

        $result=\DB::table('shop_category_shop_parameter')->
            select($columns)->
            leftJoin('shop_parameters',function($join){
                $join->on('shop_category_shop_parameter.parameter_id','=','shop_parameters.id');
            })->
            leftJoin('product_parameters',function($join) use($product_id){
                $join->on('product_parameters.parameter_id','=','shop_parameters.id');
                $join->where('product_parameters.product_id','=',$product_id);
            })->
            where('shop_category_shop_parameter.category_id',$category_id)->
            get();
        return $result;
    }


    public function findByKeyword($key)
    {
        return $this->startConditions()->
            where('name','like',$key)->
            get();
    }


    public function getNewProducts()
    {
        $columns=array(
            'name',
            'price',
            \DB::raw('shop_products.id as id'),
            \DB::raw('shop_product_photos.path as photo'),
        );
        return $this->startConditions()
        ->select($columns)
        ->leftJoin('shop_product_photos',function($join){
            $join->on('shop_products.id','=','shop_product_photos.product_id');
        })
        ->toBase()
        ->paginate(20);
    }

    public function getProductsByArray($idArray=null)
    {
        if(is_null($idArray)){
            return false;
        }
        $columns=array(
            'name',
            'price',
            \DB::raw('shop_products.id as id'),
            \DB::raw('shop_product_photos.path as photo'),
        );

        return $this->startConditions()
        ->select($columns)
        ->whereIn('shop_products.id',$idArray)
        ->leftJoin('shop_product_photos',function($join){
            $join->on('shop_products.id','=','shop_product_photos.product_id');
        })
        ->groupBy('shop_products.id')
        ->toBase()
        ->get();
    }



}
