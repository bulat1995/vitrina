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
            'user_id'=>rand(1,3),
            'product_id'=>rand(1,2),
            'checked'=>rand(0,1),
            'estimate'=>rand(1,5),
        ];
    }
}
