<?php
namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ReviewRepository;
use App\Http\Repositories\ShopCategoryRepository;
use App\Http\Repositories\ShopParameterRepository;
use App\Http\Repositories\ShopProductRepository;
use App\Http\Repositories\ShopSearchRepository;
use App\Models\Review;
use App\Models\ShopProduct;
use Illuminate\Http\Request;

class ShopProductController extends Controller
{

    //Репозиторий товара
    private $productRepository;    
    //Репозиторий категорий
    private $categoryRepository;
    //Репозиторий параметров товара
    private $paramRepository;
    //Репозиторий поиска товара
    private $searchRepository;

    public function __construct(Request $request, Request $er)
    {
        $this->categoryRepository = app(ShopCategoryRepository::class);
        $this->productRepository  = app(ShopProductRepository::class);
        $this->paramRepository    = app(ShopParameterRepository::class);
        $this->searchRepository   = app(ShopSearchRepository::class);
    }

    /**
     * Отображение товаров в категории 
     * @$id категория товара
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id = 0)
    {
        if ($id == 0) {
            $item = (object) ['name' => 'Корневая категория', '_lvl' => 0];
        }
        $treeView   = $this->categoryRepository->getNodeWithTreeAndChilds($id);
        $breadcrumb = [];
        foreach ($treeView as $entity) {
            if ($entity->id == $id) {
                $item = $entity;
            }
            if ($entity->tree == 1) {
                $breadcrumb[] = $entity;
            }
        }
        $parameters = $this->paramRepository->getParametersOnlyHave($id);
        $products   = $this->searchRepository->searchByParameters($request->input(), $id);

        return view('shop.product.index', compact('breadcrumb', 'products', 'parameters'));
    }


    /**
    *   Отображение товара 
    *   $id идентификатор товара
    *
    */
    public function show($id)
    {
        $product = ShopProduct::whereId($id)->with(['photos'])->first();
        if (empty($product)) {
            abort(404);
        };

        $cart       = $product->cart;
        $reviewRep  = new ReviewRepository();
        $reviews    = $reviewRep->getReviewsByProduct($id);
        //Параметры товара
        $params     = $this->productRepository->getProductDetailById($product->id, $product->category_id);

        $treeView   = $this->categoryRepository->getNodeWithTreeAndChilds($product->category_id);
        $breadcrumb = [];
        foreach ($treeView as $entity) {
            if ($entity->tree == 1) {
                $breadcrumb[] = $entity;
            }
        }

        
        //Добавление товара в историю просмотра $_SESSION['last_viewed']  
        $last_viewed = session('last_viewed');
        if (!empty($last_viewed)) {
            if (!in_array($product->id, $last_viewed)) {
                $size = (count($last_viewed) >= 20) ? 20 : count($last_viewed);
                for ($i = $size; $i > 0; $i--) {
                    $last_viewed[$i] = $last_viewed[$i - 1];
                }
                $last_viewed[0] = $product->id;
                session(['last_viewed' => $last_viewed]);
            }
        } else {
            session(['last_viewed' => array($product->id)]);
        }


        $review = new Review();
        return view('shop.product.show',
            compact('product', 'breadcrumb', 'params', 'cart', 'review', 'reviews')
        );
    }

}
