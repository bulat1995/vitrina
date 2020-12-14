<?php

namespace App\Http\Controllers\Shop\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\ShopCategory;
use App\Http\Repositories\ShopCategoryRepository;
use App\Http\Requests\ShopCategoryRequest;
use App\Http\Requests\ShopCategoryDeleteRequest;
use App\Http\Requests\ShopCategoryRestoreRequest;

use Database\Seeders\DatabaseSeeder;
use Database\Seeders\ShopCategorySeeder;


class ShopCategoryAdminController extends Controller
{
    private $repository;

    public function __construct()
    {
        $this->repository=app(ShopCategoryRepository::class);
        $this->middleware('auth');
    }

    /**
     * Вывод начальной страницы категорий.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item=(object)['name'=>'Корневая категория','_lft'=>0,'_rgt'=>$this->repository->getRightMax(),'_lvl'=>0];
        $items=$this->repository->getPageByItem($item);
        return view('admin.shop.category.index',compact('item','items'));
    }


    /**
     * Вывод формы для создания новой категории
     * @value parent_id= Идентификатор родителя
     * @return \Illuminate\Http\Response
     *
     */
    public function create($parent_id=0)
    {
        $item=new ShopCategory();
        $categories=$this->repository->getCategoryForComboBox();
        return view('admin.shop.category.form',
                    compact('item','categories','parent_id')
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

        $file=$request->file('logo');
        $item->logoPath=$file->store('category','public');

        $item->fill($data)->save();
        $redirect=redirect();
        if($item)
        {
            $redirect->route('admin.shop.categories.show',$item->id)
                    ->with(['success'=>'Создана новая категория']);
        }
        else{
            $redirect
                    ->back()
                    ->withErrors(['msg'=>'Ошибка сохранения'])
                    ->withInput();
        }
        dd($redirect);
        return $redirect;
    }

    /**
     * Отображение категории с дочерними элементами
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item=$this->repository->getNodeById($id);
        if(empty($item)){
            abort(404);
        }

        $breadcrumb=$this->repository->getTreeFromBottomByNode($item);
        $items=$this->repository->getPageByItem($item);
        $parent_id=$id;
        return view('admin.shop.category.index',compact('item','items','breadcrumb','parent_id'));
    }

    /**
     * Редактирование категории
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item=$this->repository->getNodeByIdWithTrashed($id);
        if(empty($item)){
            abort(404);
        }
        $breadcrumb=$this->repository->getTreeFromBottomByNode($item);
        $categories=$this->repository->getCategoryForComboBox($item);
        $parent_id=$id;
        return view('admin.shop.category.form',compact('item','categories','breadcrumb','parent_id'));
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

        $file=$request->file('logo');
        $item->logoPath=$file->store('category','public');

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
        $node=$this->repository->getNodeById($id);
        if(empty($item)){
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
            return redirect()->route('admin.shop.categories.index');
    }

    /*
    *   Восстановление удаленных категорий
    */
    public function restore(ShopCategoryRestoreRequest $request,$id)
    {
        $node=$this->repository->getNodeByIdWithTrashed($id);
        if(empty($item)){
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
