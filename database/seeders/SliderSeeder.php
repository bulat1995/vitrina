<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Slider;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $slider=new Slider();
        $slider->category='Категория';
        $slider->title='Заголовок слайда';
        $slider->describe='Описание слайда';
        $slider->image='banner_2_product.png';
        $slider->buttonText='Текст на кнопке';
        $slider->href='https://yandex.ru/';
        $slider->blank=true;
        $slider->show=true;
        $slider->rating=50;

        $slider->save();
    }
}
