<?php
/*
    Контроллер поисковых действий 

*/

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repositories\ShopSearchRepository;
use App\Http\Resources\SearchShopProductResource;
use App\Models\User;
class SearchApiController extends Controller
{


    /**
     * Поиск товара по наименованию
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function simpleSearch(Request $request)
    {
        if(!empty($request->input('search'))){
            $rep=new ShopSearchRepository();
            return  SearchShopProductResource::collection($rep->getSimpleSearch($request->input('search')));
        }
        return false;
    }

}
