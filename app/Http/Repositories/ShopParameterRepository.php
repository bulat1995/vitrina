<?php
namespace App\Http\Repositories;

use App\Http\Repositories\CoreRepository;
use App\Models\ShopParameter as Model;


class ShopParameterRepository extends CoreRepository
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
        Формирование списка параметров для товара в подразделе категории
    */
    public function getParametersWithMarks($category_id=0)
    {
        $columns=['shop_parameters.id','shop_parameters.name',\DB::raw("shop_category_shop_parameter.category_id=$category_id as has")];
        $result=$this->startConditions()
        ->select($columns)

            ->leftJoin('shop_category_shop_parameter',function($join) use($category_id){
                $join->on('shop_parameters.id','=','shop_category_shop_parameter.parameter_id');
                $join->where('shop_category_shop_parameter.category_id',$category_id);
            })->

            leftJoin('shop_categories',function($join) use($category_id){
                $join->on('shop_categories.id','=','shop_category_shop_parameter.category_id');
            })

            //->where('shop_categories.id','=',$category_id)
            ->groupBy('shop_parameters.id')
            ->toBase()
            ->orderBy('rating','ASC')
            ->get();
        return $result;
    }


}
