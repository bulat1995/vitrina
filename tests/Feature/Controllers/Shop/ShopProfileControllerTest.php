<?php

namespace Tests\Feature\Controllers\Shop;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShopProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUser()
    {
        $user=\App\Models\User::factory()->create();
        $response = $this->actingAs($user)
                    ->get('/profile');
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGuest()
    {
        $response = $this->get('/profile');
        $response->assertRedirect("/login");
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testEdit()
    {
        $user=\App\Models\User::factory()->create();
        $response = $this->actingAs($user)
                    ->get('/profile/'.$user->id.'/edit/');
        $response->assertStatus(200);
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdateWrong()
    {
        $user=\App\Models\User::factory()->create();
        $response = $this->actingAs($user)
            ->call('PATCH','/profile/'.$user->id,[
                'firstName'=>'test'
            ]);
        $response->assertSessionHasErrors('secondName');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdateSuccess()
    {
        $user=\App\Models\User::factory()->create();
        $response = $this->actingAs($user)
            ->call('PATCH','/profile/'.$user->id,[
                'firstName'=>'test',
                'secondName'=>'test',
                'name'=>'test',
                'birthday'=>'2020-01-01',
                'email'=>'test@test.ru',
                'address'=>'test',
                'keep_old_password'=>1,
            ]);
        $response->assertRedirect('/profile');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testdeleteAvatar()
    {
        $user=\App\Models\User::factory()->create();
        $user->avatar='sdfsdf.png';
        $user->save();
        $response = $this->actingAs($user)
            ->call('DELETE','/profile/deleteAvatar',[
                'id'=>1,
            ]);
        $response->assertRedirect('/profile');
    }


}
