<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Message;

class MessageFactory extends Factory
{
    protected $model=Message::class;

    public function definition()
    {
        return [
            'message'=>$this->faker->sentence(5,25),
            'sender'=>function(){
                return \App\Models\User::factory()->create()->id;
            },
            'recepient'=>function(){
                return \App\Models\User::factory()->create()->id;
            },
            'readed'=>rand(0,1),
        ];
    }
}
