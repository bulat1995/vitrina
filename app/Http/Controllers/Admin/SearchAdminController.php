<?php
/*
    Контроллер поиска по разделам админки

*/
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Repositories\ShopCategoryRepository;
use App\Http\Repositories\MessageRepository;
use App\Http\Repositories\ShopProductRepository;
use App\Models\User;
use App\Models\StaticPage;

class SearchAdminController extends Controller
{

    /**
     * Простой поиск по ключевому слову
     *
     * @return \Illuminate\Http\Response
     */
    public function simpleSearch(Request $request)
    {
        $searchValue='%'.str_replace(' ','%',$request->input('search')).'%';
        if(!empty($searchValue))
        {
            if(auth()->user()->can('admin.profiles.show')){
                $results['users']=User::where('name','like',$searchValue)->
                                        orWhere('firstName','like',$searchValue)->
                                        orWhere('secondName','like',$searchValue)->
                                        orWhere('address','like',$searchValue)->get();

            }
            if(auth()->user()->can('admin.shop.categories.show'))
            {
                $repository=new ShopCategoryRepository();
                $results['categories']=$repository->findByKeyword($searchValue);
            }
            if(auth()->user()->can('admin.messages.show'))
            {
                $repository=new MessageRepository();
                $results['messages']=($repository->findByKeyword($searchValue));
            }
            if(auth()->user()->can('admin.shop.products.show'))
            {
                $repository=new ShopProductRepository();
                $results['products']=$repository->findByKeyword($searchValue);
            }
            if(auth()->user()->can('admin.pages.show'))
            {
                $results['pages']=StaticPage::where('title','like',$searchValue)->
                        orWhere('content','like',$searchValue)->
                        orWhere('describe','like',$searchValue)->
                        get();
            }
            $searchValue=$request->input('search');
            return view('admin.search.simpleSearch',compact('searchValue','results'));
        }
        return redirect()->back();
    }
}
