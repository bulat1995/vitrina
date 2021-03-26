<?php
/**
Контроллер вывода статических страниц
 */
namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;

class ShopStaticPageController extends Controller
{

    /**
     * Вывод статической страницы 
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $page = StaticPage::whereSlug($slug)->toBase()->first();
        if (empty($page)) {
            abort(404);
        }

        return view('shop.main.page',
            [
                'page' => $page,
            ]
        );
    }

}
