<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteParameter;


class SiteParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params=array(
            array('name'=>'email','slug'=>'email','value'=>'тут должен быть email'),
            array('name'=>'phoneNumber','slug'=>'phoneNumber','value'=>'Номер телефона'),
            array('name'=>'address','slug'=>'address','value'=>'тут должен быть адрес'),
            array('name'=>'social','slug'=>'social','value'=>'Ссылки на социальные сети'),

        );
        foreach($params as $par)
        {
            $param=new SiteParameter();
            $param->name=$par['name'];
            $param->slug=$par['slug'];
            $param->value=$par['value'];
            $param->save();
        }
    }
}
