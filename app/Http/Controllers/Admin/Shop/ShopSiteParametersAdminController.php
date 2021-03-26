<?php
/*
    Параметры отображаемые на сайте
*/

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteParameter;

class ShopSiteParametersAdminController extends Controller
{
    /**
     * Вывод всех параметров
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items=SiteParameter::all();
        return view('admin.shop.siteparameters.index',compact('items'));
    }

    /**
     * Форма создания параметра
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parameter=new SiteParameter();
        return view('admin.shop.siteparameters.form',compact('parameter'));
    }

    /**
     * Сохранение нового параметра
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $parameter=new SiteParameter();
        $parameter->fill($request->input());
        if($parameter->save())
        {
            return redirect()->
                route('admin.site.parameters.index')->
                with(['success'=>'Параметр создан']);
        }
        else{
            return redirect()->
                    back()->
                    with(['error','Системная ошибка'])->
                    withInput();
        }
    }



    /**
     * Форма редактирования параметра
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $parameter=SiteParameter::where('slug',$slug)->firstOrFail();
        return view('admin.shop.siteparameters.form',compact('parameter'));
    }

    /**
     * Редактирование параметра
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $parameter=SiteParameter::where('slug',$slug)->firstOrFail();
        $parameter->fill($request->input());
        if($parameter->save())
        {
            return redirect()->
                route('admin.site.parameters.index')->
                with(['success'=>'Параметр создан']);
        }
        else{
            return redirect()->back()->
                    with(['error','Системная ошибка'])->withInput();
        }
    }

    /**
     * УДаление параметра
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $parameter=SiteParameter::where('slug',$slug)->firstOrFail();
        if($parameter->delete())
        {
            return redirect()->
                route('admin.site.parameters.index')->
                with(['success'=>'Параметр Удален']);
        }
        else{
            return redirect()->
                    back()->
                    withErrors()->
                    withInput();
        }
    }
}
