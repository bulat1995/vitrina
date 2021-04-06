<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\ShopParameter;
class ShopParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$parameter=new ShopParameter();
    	$parameter->name='Описание';
    	$parameter->inputType='text';
    	$parameter->regular='([\w|\W]+)';
    	$parameter->rating=1;
    	$parameter->required=true;
    	$parameter->save();


    	$parameter=new ShopParameter();
    	$parameter->name='Ссылка на производителя';
    	$parameter->inputType='url';
    	$parameter->regular='([\w|\W]+)';
    	$parameter->rating=2;
    	$parameter->required=true;
    	$parameter->save();


    	$parameter=new ShopParameter();
    	$parameter->name='Размер корпуса';
    	$parameter->inputType='option';
    	$parameter->regular='Маленький|Средний|Крупный|Больше крупного :-)';
    	$parameter->rating=3;
    	$parameter->required=true;
    	$parameter->save();


    	$parameter=new ShopParameter();
    	$parameter->name='Дата производства';
    	$parameter->inputType='date';
    	$parameter->regular='';
    	$parameter->rating=4;
    	$parameter->required=false;
    	$parameter->save();


        
    }
}
