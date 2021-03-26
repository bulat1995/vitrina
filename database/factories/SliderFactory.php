<?php

namespace Database\Factories;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
class SliderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Slider::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $image=$this->faker->image(config('my.slider.filePath'),499,499,null,false);
        return [
            'category'=>$this->faker->sentence(1),
            'title'=>$this->faker->sentence(3,7),
            'describe'=>$this->faker->sentence(20,25),
            'image'=>$image,
            'buttonText'=>$this->faker->sentence(1),
            'href'=>$this->faker->sentence(1),
            'blank'=>rand(0,1),
            'show'=>rand(0,1),
            'rating'=>rand(0,300),
            //'show_until'=>$this->faker-dateTimeBetween(time(),time()+2000),
        ];
    }
}
