<?php

namespace Database\Factories;

use App\Models\SiteParameter;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteParameterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SiteParameter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->word(),
            'slug'=>$this->faker->word(),
            'value'=>$this->faker->word(),
        ];
    }
}
