<?php

namespace Tests\Feature\Controllers\Shop;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Message;
use App\Models\User;
class ShopMessageControllerTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Гость
     *
     * @return void
     */
    public function testMessageGuest()
    {
        $response = $this->get('/messages');
        $response->assertStatus(302);
    }

    /**
     * Авторизованный пользователь
     *
     * @return void
     */

    public function testMessageUser()
    {
        $user=\App\Models\User::factory()->create();
        $response = $this->actingAs($user)->get('/messages');
        $response->assertStatus(200);
    }

    /**
     * Ошибка заполнения формы
     *
     * @return void
     */

    public function testMessageStoreBad()
    {
        $user=\App\Models\User::factory()->create();
        $recepient=\App\Models\User::factory()->create();
        $response = 
            $this->actingAs($user)->
            call('POST','/messages',[
                'message'=>'',
            ]);

        $response->assertSessionHasErrors('message');
    }

    /**
     * Успешное добавление сообщения
     *
     * @return void
     */

    public function testMessageStoreGood()
    {
        $user=\App\Models\User::factory()->create();
        $recepient=\App\Models\User::factory()->create();
        $response = 
            $this->actingAs($user)->
            call('POST','/messages',[
                'message'=>'sd',
            ]);
        $this->assertTrue(Message::count()>0);
        $response->assertRedirect('/messages');
    }


    /**
    * Форма редактирования
    */
    public function testMessageEdit()
    {
        for($i=0;$i<22;$i++)
        {
            $message=\App\Models\Message::factory()->create();
            $user=User::find($message->sender);
            
            $response = $this->actingAs($user)->
                get('/messages/'.$message->id.'/edit/');

            if($message->readed==0)
            {
                $response->assertStatus(200);
            }
            else{
                $response->assertStatus(302);
            }
        }
    }


    /*
        Обновление сообщения
    */
    public function testMessageUpdate()
    {
        $messages=\App\Models\Message::factory(22)->create();
        
        foreach($messages as $message)
        {
            $user=User::find($message->sender);
            
            $response = $this->actingAs($user)->
                call('PATCH','/messages/'.$message->id,[
                    'message'=>'dfsdf'
                ]);

            if($message->readed==0)
            {
                $response->assertRedirect('/messages?'.$message->recepient);
            }
            else{
                $response->assertStatus(302);
            }
        }
    }

    /**
    * Удаление сообщения
    */
    public function testMessageDelete()
    {
        for($i=0;$i<22;$i++)
        {
            $message=\App\Models\Message::factory()->create();
            $user=User::find($message->sender);
            $this->assertTrue(Message::count()==1);
            $response = $this->actingAs($user)->
                call('DELETE','/messages/'.$message->id,[
                    'id'=>$message->id,
                    'recepient'=>$message->recepient,
                ]);
            $this->assertTrue(Message::count()==0);
            $response->assertStatus(302);
            
        }
    }


}
