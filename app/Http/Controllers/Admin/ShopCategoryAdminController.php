<?php
/*
    Контроллер работы с категориями товаров
*/

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\ShopCategory;
use App\Models\ShopProduct;
use App\Http\Repositories\ShopCategoryRepository;
use App\Http\Repositories\ShopParameterRepository;

use App\Http\Requests\ShopCategoryRequest;
use App\Http\Requests\ShopCategoryDeleteRequest;
use App\Http\Requests\ShopCategoryRestoreRequest;

use Database\Seeders\DatabaseSeeder;
use Database\Seeders\ShopCategorySeeder;


class ShopCategoryAdminController extends Controller
{
    private $repository;
    private $paramRepository;

    public function __construct(Request $request,Request $er)
    {
        $this->repository=app(ShopCategoryRepository::class);
        $this->paramRepository=app(ShopParameterRepository::class);
    }

    /**
     * Отображение категории с дочерними элементами
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id=0)
    {
        if($id==0){
            $item=(object)['name'=>'Корневая категория','_lvl'=>0];
        }

        $treeView=$this->repository->getNodeWithTreeAndChilds($id);
        $breadcrumb=[];
        $items=[];
        foreach($treeView as $entity){
            if($entity->id==$id){
                $item=$entity;
            }
            if($entity->tree==1){
                $breadcrumb[]=$entity;
            }
            else{
                $items[]=$entity;
            }
        }

        $products=ShopProduct::where('category_id',$id)->
                limit(10)->get();

        return view('admin.shop.category.index',
            compact('item','items','breadcrumb','products')
        );
    }



    /**
     * Вывод формы для создания новой категории
     * @value parent_id= Идентификатор родителя
     * @return \Illuminate\Http\Response
     *
     */
    public function create($parent_id=0)
    {
        $tree=$this->repository->getNodeForForm(0);
        $item=new ShopCategory();
        $breadcrumb=[];
        $categories=[];
        foreach($tree as $entity)
        {
            if($entity->tree){
                $breadcrumb[]=$entity;
            }
            if($entity->hide!=1){
                $categories[]=$entity;
            }
        }
        $params=$this->paramRepository->getParametersWithMarks();
        return view('admin.shop.category.form',
            compact('item','categories','parent_id','params')
        );
    }

    /**
     * Формирование новой категории.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopCategoryRequest $request)
    {
        $item=new ShopCategory();
        $data=$request->input();
        $item->fill($data)->save();
        if($item)
        {
            return redirect()->route('admin.shop.categories.show',$item->id)
                    ->with(['success'=>'Создана новая категория']);
        }
        else{
            return redirect()
                    ->back()
                    ->withErrors(['msg'=>'Ошибка сохранения'])
                    ->withInput();
        }

    }
    /**
     * Редактирование категории
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($parent_id)
    {
        $tree=$this->repository->getNodeForForm($parent_id);
        $item=[];
        $breadcrumb=[];
        $categories=[];
        foreach($tree as $entity)
        {
            if($entity->tree){
                $breadcrumb[]=$entity;
            }
            if($entity->hide!=1){
                $categories[]=$entity;
            }
            if($entity->id==$parent_id){
                $item=$entity;
            }
        }
        if(empty($item)){
            abort(404);
        }
        $params=$this->paramRepository->getParametersWithMarks($parent_id);
        return view('admin.shop.category.form',compact('item','categories','breadcrumb','parent_id','params'));
    }

    /**
     * Обновление данных категории
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShopCategoryRequest $request, $id)
    {
        $data=$request->all();
        $item=$this->repository->getNodeById($id);
        $item->fill($data)->save();

        if($item)
        {
            return redirect()
                    ->route('admin.shop.categories.show',$item->id)
                    ->with(['success'=>"Категория [$item->name] успешно отредактирована"]);
        }
        else{
            return redirect()
                    ->back()
                    ->withErrors(['msg'=>'Ошибка сохранения'])
                    ->withInput();
        }
    }

    /**
     * Удаление категории
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShopCategoryDeleteRequest $request,$id)
    {
        $node=$this->repository->getNodeByIdWithTrashed($id);
        if(empty($node)){
            abort(404);
        }
        //Мягкое удаление
        $soft=(bool)$request->input('soft');
        //Удаление с потомками
        $withDescedents=(bool)$request->input('withDescedents');

        if($withDescedents){
            if($soft){
                $this->repository->softDelete($node);
            }
            else{
                $this->repository->delete($node);
            }
        }
        elseif($soft){
            $node->delete();
        }
        else{
            $this->repository->behead($node);
        }

        if($soft){
            return redirect()->route('admin.shop.categories.edit',$node->id);
        }
        elseif($node->parent_id!==null)
            return redirect()->route('admin.shop.categories.show',$node->parent_id);
        else
            return redirect()->route('admin.shop.categories.show');
    }

    /*
    *   Восстановление удаленных категорий
    */
    public function restore(ShopCategoryRestoreRequest $request,$id)
    {
        $node=$this->repository->getNodeByIdWithTrashed($id);
        if(empty($node)){
            abort(404);
        }
        $withDescedents=(bool)$request->input('withDescedents');
        if($withDescedents){
            $result=$this->repository->restore($node);
        }
        else
        {
            $node->restore();
        }
        return redirect()->route('admin.shop.categories.edit',$node->id);
    }
}
