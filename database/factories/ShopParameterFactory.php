<?php

namespace Database\Factories;

use App\Models\ShopParameter;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShopParameterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShopParameter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $regular=array(
            '/([0-9]+)/',
            '/([\w|\W]+)/',
            '/([0-9]{4}-[0-9]{2}-[0-9]{2})/i',
            'url',
            'option',
        );

        $key=rand(0,count(ShopParameter::inputTypes)-1);

        return [
            'name'=>$this->faker->word(),
            'regular'=>$regular[$key],
            'inputType'=>ShopParameter::inputTypes[$key],
            'required'=>true,
        ];
    }
}
