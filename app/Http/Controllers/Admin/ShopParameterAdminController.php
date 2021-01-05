<?php
/*
    Работа с параметрами товаров

*/
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ShopParameterRequest;


use App\Models\ShopParameter;

class ShopParameterAdminController extends Controller
{
    /**
     * Отображение всех параметров
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters=ShopParameter::get();
        return view('admin.shop.parameter.index',compact('parameters'));
    }

    /**
     * Отображение формы добавления параметра
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parameter=new ShopParameter();
        return view('admin.shop.parameter.form',compact('parameter'));
    }

    /**
     * Добавление параметра
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopParameterRequest $request)
    {
        $parameter=new ShopParameter();
        $parameter->fill($request->all());
        $result=$parameter->save();
        if($result)
        {
            return redirect()->
                    route('admin.shop.parameters.edit',$parameter->id)->
                    with(['success'=>'Параметр успешно сохранен']);
        }
        else{
            return redirect()->
                    back()->
                    withInput()->
                    withErrors();
        }
    }



    /**
     * Отображение формы редактирования
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parameter=ShopParameter::findOrFail($id);
        return view('admin.shop.parameter.form',compact('parameter'));
    }

    /**
     * Редактирование параметра
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShopParameterRequest $request, $id)
    {
        $parameter=ShopParameter::findOrFail($id);
        $parameter->fill($request->all());
        $result=$parameter->save();
        if($result)
        {
            return redirect()->route('admin.shop.parameters.edit',$parameter->id)->
                with(['success'=>'Параметр успешно сохранен']);
        }
        else{
            return redirect()->
                    back()->
                    withInput()->
                    withErrors();
        }
    }

    /**
     * Удаление параметра
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parameter=ShopParameter::findOrFail($id);
        if($parameter->delete())
        {
            return redirect()->route('admin.shop.parameters.index')->with([
                'success'=>'Параметр "'.$parameter->name.'" успешно удален'
            ]);
        }
    }
}
