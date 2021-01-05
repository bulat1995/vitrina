<?php
/*
    Контроллер работы с товаром
*/

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\ShopProduct;
use App\Models\ShopCategory;

use App\Http\Repositories\ShopProductRepository;
use App\Http\Repositories\ShopParameterRepository;
use App\Http\Repositories\ShopCategoryRepository;
use App\Http\Requests\ShopProductRequest;

class ShopProductAdminController extends Controller
{
    private $repository;
    private $categRepository;

    public function __construct()
    {
        $this->repository=app(ShopProductRepository::class);
        $this->categRepository=app(ShopCategoryRepository::class);
    }


    /**
     * Отображение списка товаров по id категории.
     * @return \Illuminate\Http\Response
     */
    public function index($category_id=0)
    {
        $treeView=$this->categRepository->getNodeWithTreeAndChilds($category_id);
        $breadcrumb=[];
        foreach($treeView as $entity){
            if($entity->tree==1){
                $breadcrumb[]=$entity;
            }
        }
        $products=ShopProduct::where('category_id',$category_id)->get();
        return view('admin.shop.product.index',
            compact('breadcrumb','products')
        );
    }


    /**
     * Отображение формы создания товара
     * @return \Illuminate\Http\Response
     */
    public function create($cat_id=0)
    {
        $category=ShopCategory::findOrFail($cat_id);
        $product=new ShopProduct();

        $product->category_id=$cat_id;
        $params=$this->repository->getProductDetailById(0,$cat_id);

        return view('admin.shop.product.form',
                compact('product','params','category')
            );
    }

    /**
     * Сохранение нового товара
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopProductRequest $request,$category_id=0)
    {
        $category=ShopCategory::findOrFail($category_id);
        $product=new ShopProduct($request->all());
        $product->category_id=$category_id;
        $result=$product->save();
        if($result){
            return  redirect()->
                    route('admin.shop.products.show',$product->id)->
                    with(['success'=>'Товар успешно сохранен']);
        }
        else{
            return  redirect()->
                    back()->
                    withErrors(['msg'=>'Произошла ошибка сохранения']);
        }
    }

    /**
     * Отображение  товара по его идентификатору
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=ShopProduct::whereId($id)->with(['photos'])->first();
        if(empty($product)){
            abort(404);
        };
        $params=$this->repository->getProductDetailById($product->id,$product->category_id);

        $treeView=$this->categRepository->getNodeWithTreeAndChilds($product->category_id);
        $breadcrumb=[];
        foreach($treeView as $entity){
            if($entity->tree==1){
                $breadcrumb[]=$entity;
            }
        }
        return view('admin.shop.product.show',
                compact('product','breadcrumb','params')
        );
    }

    /**
     * Отображение формы редактирования товара
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Объедини в будующем
        $product=ShopProduct::whereId($id)->with(['photos'])->first();
        $category=ShopCategory::findOrFail($product->category_id);

        $params=$this->repository->getProductDetailById($product->id,$product->category_id);
        return view('admin.shop.product.form',compact('product','params','category'));
    }


    /**
     * Обновление данных товара
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShopProductRequest $request, $id)
    {
        $product=ShopProduct::findOrFail($id);
        $product->fill($request->all());
        $product->save();
        if($product)
        {
            return redirect()->route('admin.shop.products.show',$product->id)->
            with(['success'=>'Товар успешно сохранен']);
        }
        else{
            return redirect()->
                    back()->
                    withErrors(['msg'=>'Произошла ошибка сохранения'])->
                    withInput();
        }
    }

    /**
     * Удаление товара по его идентификатору
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=ShopProduct::findOrFail($id);
        if($product->delete())
        {
            return redirect()->route('admin.shop.products.index',$product->category_id)->
            with(['success'=>'Товар успешно удален']);
        }
    }
}
