<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ShopCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();
        
        $item[]=['name'=>'Компьютеры','_lft'=>1,'_rgt'=>8,'_lvl'=>1,'parent_id'=>null,'created_at'=>$now];
        $item[]=['name'=>'Жесткие диски','_lft'=>2,'_rgt'=>3,'_lvl'=>2,'parent_id'=>1,'created_at'=>$now];
        $item[]=['name'=>'Оперативная память','_lft'=>4,'_rgt'=>7,'_lvl'=>2,'parent_id'=>1,'created_at'=>$now];
        $item[]=['name'=>'1G','_lft'=>5,'_rgt'=>6,'_lvl'=>3,'parent_id'=>3,'created_at'=>$now];
        $item[]=['name'=>'Принтеры','_lft'=>9,'_rgt'=>10,'_lvl'=>1,'parent_id'=>null,'created_at'=>$now];

        \DB::table('shop_categories')->insert($item);
    }
}
