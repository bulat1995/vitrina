<?php
/*
    Контроллер основной страницы проекта
*/

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ShopProductRepository;
use App\Models\Slider;
use Carbon\Carbon;
class ShopMainPageController extends Controller
{

    /**
     *  Страница выполняемая по умолчанию
     **/
    public function index()
    {

        $slider=Slider::where(function ($where) {
                            $where->whereTime('show_until', '<=', Carbon::now());
                            $where->orWhere('show_until', null);
                        })->
                        where('show', '<>', 0)->
                        toBase()->
                        orderBy('rating', 'DESC')->
                        get();

        $prodRepository = new ShopProductRepository();
        return view('shop.main.index',
            [
                'slider'      => $slider,
                'products'    => $prodRepository->getNewProducts(),
                'last_viewed' => $prodRepository->getProductsByArray(session('last_viewed')),
            ]
        );
    }

}
