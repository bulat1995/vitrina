<?php
/*
    Контроллер для работы со слайдером сайта

*/
namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Http\Requests\ShopSliderUpdateRequest;
use App\Http\Requests\ShopSliderCreateRequest;


class ShopSliderAdminController extends Controller
{
    /**
     * Список доступных слайдеров
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders=Slider::orderBy('rating','DESC')->paginate(20);
        return view('admin.shop.slider.index',compact('sliders'));
    }

    /**
     * ФОрма Создания нового слайдера
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $slider=new Slider();
        return view('admin.shop.slider.form',compact('slider'));
    }

    /**
     * Формирование нового слайдера
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopSliderCreateRequest $request)
    {
        $slider=new Slider($request->input());
        if($slider->save())
        {
            return redirect()->route('admin.shop.sliders.index')->
                with(['success'=>'Создан новый слайдер']);
        }
        else{
            return redirect()->back()->
            withErrors()->withInput();
        }
    }



    /**
     * Отображение формы редактирования слайдера
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider=Slider::findOrFail($id);
        return view('admin.shop.slider.form',compact('slider'));
    }

    /**
     * Редактирование слайдера
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShopSliderUpdateRequest $request, $id)
    {
        $slider=Slider::findOrFail($id);
        $slider->fill($request->input());

        $slider->touch();

        if($slider->save())
        {
            return redirect()->route('admin.shop.sliders.index')->with([
                'success'=>'Слайдер успешно отредактирован',
            ]);
        }
        else{
            return back()->withInput()->withErrors([
                'errors'=>'Something went wrong',
            ]);
        }
    }

    /**
     * Удаление слайдера
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider=Slider::findOrFail($id);
        if($slider->delete())
        {
            return redirect()->route('admin.shop.sliders.index')->with([
                'success'=>'Слайдер успешно Удален',
            ]);
        }
        else{
            return back()->withInput()->withErrors([
                'errors'=>'Something went wrong',
            ]);
        }
    }
}
