<?php
/*
Контроллер для поиска товаров
 */
namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ShopSearchRepository;
use App\Models\ShopParameter;
use Illuminate\Http\Request;

class ShopSearchController extends Controller
{
    //Репозиторий поиска товара
    private $repository;

    public function __construct()
    {
        $this->repository = new ShopSearchRepository();
    }

    /**
     * Поиск товаров по сайту.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchValue = $request->input('search');
        if (empty($searchValue)) {
            return redirect()->back();
        }
        $products      = $this->repository->searchByParameters($request->input());
        $productsCount = count($products);
        //Добавление ссылок после paginate
        $products->appends($request->input())->links();

        $parameters = ShopParameter::orderBy('rating', 'DESC')->get();
        return view('shop.search.index', compact('products', 'parameters', 'productsCount'));
    }

}
