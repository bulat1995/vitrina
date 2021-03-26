<?php

namespace Database\Factories;

use App\Models\ShopProductPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ShopProduct;

class ShopProductPhotoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model =ShopProductPhoto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product_id=ShopProduct::count();
        return [
            'path'=>$this->faker->image(config('my.product.photo.filePath'),200,200,null,false),
            'product_id'=>rand(1,$product_id)
        ];
    }
}
