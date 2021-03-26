<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShopCategory;
use App\Models\ShopParameter;

class ShopCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $item[]=['name'=>'Компьютеры','parent_id'=>null];
        $item[]=['name'=>'Жесткие диски','parent_id'=>1];
        $item[]=['name'=>'Оперативная память','parent_id'=>1];
        $item[]=['name'=>'1G','parent_id'=>3];
        $item[]=['name'=>'Принтеры','parent_id'=>null];
        $item[]=['name'=>'Сварочные аппараты','parent_id'=>null];
        $item[]=['name'=>'Ресанта','parent_id'=>6];

        //$params=ShopParameter::all()->toArray();

        foreach($item as $cat){
            $category=new ShopCategory();
            $category->name=$cat['name'];
            $category->parent_id=$cat['parent_id'];
            $category->save();
            $category->parameters=array(1,2);
        }

    }
}
