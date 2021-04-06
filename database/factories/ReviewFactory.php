<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'review'=>$this->faker->sentences(18,25),
            'user_id'=>function(){
                return \App\Models\User::factory()->create()->id;
            },
            'product_id'=>function(){
                return \App\Models\ShopProduct::factory()->create()->id;
            },
            'checked'=>rand(0,1),
            'estimate'=>rand(1,5),
        ];
    }
}
