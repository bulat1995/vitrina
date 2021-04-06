<?php

namespace Database\Factories;

use App\Models\StaticPage;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaticPageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StaticPage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'slug'=>$this->faker->word,
            'title'=>$this->faker->sentence(1,3),
            'describe'=>$this->faker->sentence(20,100),
            'content'=>$this->faker->sentence(200,1000),
            'rating'=>rand(10,100),
            'in_menu'=>rand(0,1),
            'user_id'=>function(){
                return \App\Models\User::factory()->create()->id;
            },
        ];
    }
}
