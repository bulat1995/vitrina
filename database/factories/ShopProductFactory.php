<?php

namespace Database\Factories;

use App\Models\ShopProduct;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ShopCategory;
class ShopProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShopProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $categoryCount=ShopCategory::count();
        $category=rand(1,$categoryCount);
        return [
            'name'=>$this->faker->sentence(1,2),
            'price'=>rand(2000,7000),
            'category_id'=>function(){
                return \App\Models\ShopCategory::factory()->create()->id;
            },
            'user'=>function(){
                return \App\Models\User::factory()->create()->id;
            },

        ];
    }
}
