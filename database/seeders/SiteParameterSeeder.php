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
            array('name'=>'email','slug'=>'email','value'=>'email'),
            array('name'=>'phoneNumber','slug'=>'phoneNumber','value'=>'phoneNumber'),
            array('name'=>'address','slug'=>'address','value'=>'address'),
            array('name'=>'social','slug'=>'social','value'=>'social'),

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
