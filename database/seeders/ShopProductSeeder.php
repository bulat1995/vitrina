<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\ShopProduct;

class ShopProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$product = new ShopProduct();

    	$product->name='Принтер Samsung SCX-4200';
    	$product->category_id=5;
    	$product->user=1;
    	$product->price=rand(3000,10000);
    	$product->save();

    }
}
