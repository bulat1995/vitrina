<?php
namespace App\Http\Repositories;

use App\Http\Repositories\CoreRepository;
use App\Models\ShopProduct as Model;

class ShopSearchRepository extends CoreRepository
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
        Простой поиск по ключевым словам
    */
    public function getSimpleSearch($value)
    {
        $values='%'.str_replace(' ','%',$value).'%';
        $result=$this->startConditions()->
                selectRaw('*')->
                where('name','like',$values)->
                with(['photos'])->
                paginate(8);
        return $result;
    }

    /*
        Расширенный поиск по параметрам товара
    */
    public function searchByParameters(array $fields,$category_id=null)
    {
        $betweenValue=[];
        foreach($fields as $key=>$value)
        {
            if(preg_match_all('/(min|max|val)-([\d+])/',$key,$paramKey))
            {
                $betweenValue[$paramKey[2][0]][$paramKey[1][0]]=$value;
            }
        }
        $columns=[
            \DB::raw('DISTINCT(shop_products.id)'),
            \DB::raw('shop_products.name as name'),
            'price',
            \DB::raw('shop_product_photos.path as photo'),
        ];

        \DB::enableQueryLog();
        $result=\DB::table('shop_products')->
                select($columns)->
                //value
                leftJoin('product_parameters',function($join) {
                    $join->on('product_parameters.product_id','=','shop_products.id');
                })->
                //id val
                leftJoin('shop_parameters',function($join){
                    $join->on('product_parameters.parameter_id','=','shop_parameters.id');
                })
                ->
                //photos
                leftJoin('shop_product_photos',function($join){
                    $join->on('shop_product_photos.product_id','=','shop_products.id');
                });

                //Поиск по наименованию
                if(!empty($fields['search']))
                {
                    $searchValue='%'.str_replace(' ','%',$fields['search']).'%';
                    $result->where('shop_products.name','like',$searchValue);
                }

                $min=request()->input('price-min');
                $max=request()->input('price-max');

                if(!is_null($min))
                    $result->where('price','>=',(int)$min);
                if(!is_null($max))
                    $result->where('price','<=',(int)$max);

                foreach($betweenValue as $key=>$value)
                {
                    $result->where(function($result)use($key,$value){
                        $result->where('product_parameters.parameter_id',$key);
                        if(is_array($value)){
                            foreach($value as $val=>$var){
                                if($val=='min'){
                                    if(!is_null($var))
                                        $result->where('value','>=',$var);
                                }
                                elseif($val=='max'){
                                    if(!is_null($var))
                                        $result->where('value','<=',(int)$var);
                                }
                                else{
                                    if(is_array($var)){
                                        $result->where(function($where) use($var){
                                            foreach($var as $elem=>$item)
                                            {
                                                $where->orWhere('value',$item);
                                            }
                                        });
                                    }
                                    else{
                                        $result->where('value',$var);
                                    }
                                }
                            }
                        }
                    });
                }
                //Поиск в категории
                if(!is_null($category_id)){
                    $result->where('shop_products.category_id',$category_id);
                }

                if(isset($fields['sort']))
                {
                    if(!is_null($fields['sort']))
                    {
                        switch($fields['sort'])
                        {
                            case 0: $result->orderBy('shop_products.price','ASC'); break;
                            case 1: $result->orderBy('shop_products.price','DESC'); break;
                            case 2: $result->orderBy('shop_products.name','ASC'); break;
                            case 3: $result->orderBy('shop_products.name','DESC'); break;
                        }
                    }
                }
                else{
                    $result->orderBy('shop_products.price','ASC');
                }


                $result->groupBy('shop_products.id');
                $res=$result->paginate(20);
                // $rer=\DB::getQueryLog();
                // $prodId=[];
                // foreach($res as $key)
                // {
                //     $prodId[]=$key->id;
                // }
                //dd($betweenValue,$rer[0],$prodId);
                return $res;
    }
}
