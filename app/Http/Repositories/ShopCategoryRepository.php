<?php
namespace App\Http\Repositories;

use App\Models\ShopCategory as Model;
use App\Http\Repositories\CoreRepository;
use App\Http\Repositories\NestedSetRepository;

class ShopCategoryRepository extends CoreRepository
{
    use NestedSetRepository;

    protected $model;

    protected $repository;

    public function __construct()
    {
        parent::__construct();
    }

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getTreeFromBottomByNode($node)
    {
        $columns=['id','name'];
        return $this->startConditions()
                ->select($columns)
                ->where('_lft','<=',$node->_lft)
                ->where('_rgt','>=',$node->_rgt)
                ->toBase()
                ->orderBy('_lft','ASC')
                ->get();
    }


    /*
         вывод категории с товаром
    */
    /*
        Возврат одного узла по идентификатору
    */
    public function getNodeByIdWithProducts($id)
    {
        return $this->startConditions()->with(['products'])->find($id);
    }

    /*
        Формирование запроса для формы редактирования
    */
    public function getNodeForForm($parent_id=0)
    {
        if($parent_id==0)
        {
            $result=$this->startConditions()->
                orderBy('_lft','ASC')->
                get();
        }
        else{
            $columns=[
                \DB::raw('shop_2.*'),
                \DB::raw('(shop_categories._lft<=shop_2._lft AND shop_categories._rgt >=shop_2._rgt) as  hide'),
                \DB::raw('(shop_2._lft<=shop_categories._lft and shop_2._rgt>=shop_categories._rgt ) as  tree'),
            ];
            $result=$this->startConditions()->
            select($columns)->
            leftJoin('shop_categories as shop_2',function($join){
                $join->on('shop_2.id','>',\DB::raw('0'));
            })->
            where('shop_categories.id',$parent_id)->
            orderBy('shop_2._lft','ASC')->
            //toBase()->
            get();
        }
        return  $result;
    }

    /*
        Формирование списка для html select
    */
    public function getCategoryForComboBox($node=null)
    {
        $columns=['id','name','_lvl'];
        $result=$this->startConditions()->select($columns);
        if(!empty($node)){
            $result->where('_lft','<',$node->_lft);
            $result->orWhere('_rgt','>',$node->_rgt);
        }
        return $result->orderBy('_lft','ASC')
        ->toBase()
        ->get();
    }


    /*
        Вывод дерева для ShopCategoryController::show()
    */
    public function getNodeWithTreeAndChilds($parent_id)
    {
        //Корневая категория
        if($parent_id==0){
            $result=$this->startConditions()->
            select(['id','name','logoPath','_lvl',\DB::raw('0 as tree')])->
            toBase()->
            orderBy('_lft','ASC')->
            where('shop_categories._lvl',1)->
            get();
        }
        //Дочерняя категория
        else{
            $columns=[
                \DB::raw('shop_categories_2.id'),
                \DB::raw('shop_categories_2.name'),
                \DB::raw('shop_categories_2._lvl'),
                \DB::raw('shop_categories_2.logoPath'),
                \DB::raw('shop_categories_2._lft<=shop_categories._lft as tree')
            ];
            $result=$this->startConditions()->
            select($columns)->
            leftJoin(\DB::raw('shop_categories as shop_categories_2'),function($join){
                $join->on(\DB::raw('shop_categories._lvl+1'),'>=',\DB::raw('shop_categories_2._lvl'));
                $join->where(function ($query){
                    $query->where(function($query){
                        $query->where(\DB::raw('shop_categories._lft'),'>=',\DB::raw('shop_categories_2._lft'));
                        $query->where(\DB::raw('shop_categories._rgt'),'<',\DB::raw('shop_categories_2._rgt'));
                    });
                    $query->orWhere(function($query){
                        $query->where(\DB::raw('shop_categories._lft'),'<=',\DB::raw('shop_categories_2._lft'));
                        $query->where(\DB::raw('shop_categories._rgt'),'>=',\DB::raw('shop_categories_2._rgt'));
                    });
                });
            })->
            toBase()->
            orderBy('shop_categories_2._lft','ASC')->
            where('shop_categories.id',$parent_id)->
            get();
        }
        return $result;
    }



    /*
        Получить список параметров со значениями для категории
    */
    public function getParameters($category_id=0)
    {
        $columns=[
            'shop_parameters.id',
             \DB::raw('shop_parameters.name as parameterName'),
            \DB::raw('shop_categories.id as category'),
            'shop_parameters.inputType',
            'shop_parameters.regular',
            'shop_parameters.required',
            'rating',
            \DB::raw('null as value')
        ];

        $result=$this->startConditions()
        ->select($columns)
        ->leftJoin('shop_category_shop_parameter',function($join){
            $join->on('shop_categories.id','=','shop_category_shop_parameter.category_id');
        })        
        ->leftJoin('shop_parameters',function($join){
            $join->on('shop_parameters.id','=','shop_category_shop_parameter.parameter_id');
        })

        ->where('shop_categories.id',$category_id)
        ->toBase()
        ->orderBy('rating ','ASC')
        ->get();
        return $result;
    }



    /*
        Поиск по ключевому слову
    */
    public function findByKeyword($key)
    {
        return $this->startConditions()->where('name','like',$key)->get();
    }




}
