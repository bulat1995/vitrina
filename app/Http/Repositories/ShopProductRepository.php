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
            //toBase()->
            get();
            //dd($result);
        return $result;
    }




}
