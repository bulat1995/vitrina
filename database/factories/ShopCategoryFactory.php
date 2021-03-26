<?php

namespace Database\Factories;

use App\Models\ShopCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShopCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShopCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $image=$this->faker->image('public/storage/category/',40,40, 'cats', false);
        return [
            'name'=>$this->faker->name,
            'logoPath' => $image,
            'parent_id'=>rand(0,5)
        ];
    }
}
