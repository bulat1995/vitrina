<?php
/*
    Работа со статическими  страницами

*/
namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaticPage;
use App\Http\Requests\StaticPageRequest;

class ShopStaticPageAdminController extends Controller
{
    /**
     * Отображение списка статей
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages=StaticPage::all();
        return view('admin.shop.page.index',compact('pages'));
    }

    /**
     * Вывод формы добавления статической страницы
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page=new StaticPage();
        return view('admin.shop.page.form',compact('page'));
    }

    /**
     * Добавление статической страницы
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaticPageRequest $request)
    {
        $page=new StaticPage($request->input());
        $page->user=auth()->user()->id;
        if($page->save()){
            return redirect()->route('admin.pages.show',$page->id)->
            with(['success'=>'Статья сохранена']);
        }
        return back()->withErrors(['msg'=>'Ошибка сохранения'])->withInput();
    }

    /**
     * Отображение статической страницы
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page=StaticPage::findOrFail($id);
        return view('admin.shop.page.show',compact('page'));
    }


    /**
     * Форма редактирования статической страницы
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page=StaticPage::findOrFail($id);
        return view('admin.shop.page.form',compact('page'));
    }

    /**
     * Обновление статической страницы
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page=StaticPage::findOrFail($id);
        $page->fill($request->all());
        if($page->save()){
            return redirect()->route('admin.pages.show',$page->id)->
            with(['success'=>'Статья сохранена']);
        }
        return back()->withErrors(['msg'=>'Ошибка сохранения'])->withInput();
    }

    /**
     * Удаление статической страницы
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page=StaticPage::findOrFail($id);
        if($page->delete())
        {
            return redirect()->route('admin.pages.index')->
                    with(['success'=>'Статья успешно удалена']);
        }
    }
}
