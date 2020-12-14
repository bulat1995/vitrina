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
        Постраничный вывод категории
    */
    public function getPageByItem($node,$pageLimit=10)
    {
        if(!empty($node))
        {
            $columns=['id','name','_lft','_rgt','logoPath'];
            return $this->startConditions()
                    ->select($columns)
                    ->where('_lft','>=',$node->_lft)
                    ->orderBy('_lft','ASC')
                    ->where('_rgt','<=',$node->_rgt)
                    ->where('_lvl','=',$node->_lvl+1)->toBase()->get();
                    //->paginate($pageLimit);
        }
        else{
            return false;
        }
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
}
