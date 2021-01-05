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
    public function getParametersWithMarks($id=0)
    {
        $columns=['shop_parameters.id','shop_parameters.name',\DB::raw("shop_categories.id=$id as has")];
        $result=$this->startConditions()
        ->select($columns)
            ->leftJoin('shop_category_shop_parameter',function($join) use($id){
                $join->on('shop_parameters.id','=','shop_category_shop_parameter.parameter_id');

                $join->rightJoin('shop_categories',function($join)use ($id){
                    $join->on('shop_categories.id','=','shop_category_shop_parameter.category_id')
                    ->where('shop_categories.id','=',$id);
                });
            })
            ->toBase()
            ->orderBy('name','ASC')
            ->get();
        return $result;
    }

    /*
        Получить список параметров для категории
    */
    public function getParametersOnlyHave($category_id=0)
    {
        $columns=[
            'shop_parameters.id',
            'shop_parameters.name',
            'shop_parameters.inputType',
            'shop_parameters.regular',
            'shop_parameters.required',
            \DB::raw('null as value')
        ];
        $result=$this->startConditions()
        ->select($columns)
            ->leftJoin('shop_category_shop_parameter',function($join) use($category_id){
                $join->on('shop_parameters.id','=','shop_category_shop_parameter.parameter_id');

                $join->rightJoin('shop_categories',function($join)use ($category_id){
                    $join->on('shop_categories.id','=','shop_category_shop_parameter.category_id')
                    ->where('shop_categories.id','=',$category_id);
                });
            })
            ->where('shop_categories.id',$category_id)
            ->toBase()
            ->orderBy('name','ASC')
            ->get();
        return $result;
    }

}
