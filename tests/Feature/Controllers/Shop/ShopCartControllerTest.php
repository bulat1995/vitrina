<?php

namespace Tests\Feature\Controllers\Shop;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\ShopCart;
use App\Models\ShopProduct;

class ShopCartControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Просмотр корзины пользователем
     *
     * @return void
     */
    public function testCartIndexAuth()
    {
        $user=new User();
        $response = $this->actingAs($user)->get('/cart');
        $response->assertStatus(200);
    }


    /**
     * Просмотр корзины гостем
     *
     * @return void
     */
    public function testCartIndexGuest()
    {
        $response = $this->get('/cart');
        $response->assertRedirect('/login');
    }


    /**
     * Добавление товара в корзину пользователем
     *
     * @return void
     */
    public function testCartStoreUser()
    {

        $user=\App\Models\User::factory()->create();

        $product=\App\Models\ShopProduct::factory()->create();

        $response = $this->actingAs($user)->call('POST','/cart',[
            'product_id'=>1,
            'quantity'=>7
        ]);

        $this->assertTrue(ShopCart::count()>0);
        $response->assertRedirect('/cart');
    }


    /**
     * Добавление товара в корзину пользователем
     * Неверно заполнена форма
     *
     * @return void
     */
    public function testCartStoreUserWrongRequest()
    {

        $user=\App\Models\User::factory()->create();

        $product=\App\Models\ShopProduct::factory()->create();

        $response = $this->actingAs($user)->call('POST','/cart',[
            'quantity'=>7
        ]);
        $response->assertSessionHasErrors('product_id');
        $this->assertTrue(ShopCart::count()==0);
        $response->assertStatus(302);
    }




    /**
     * Попытка добавления Товара в корзину Гостем
     *
     * @return void
     */
    public function testCartStoreGuest()
    {
        $user=\App\Models\User::factory()->create();
        
        $product=\App\Models\ShopProduct::factory()->create();

        $response = $this->call('POST','/cart',[
            'product_id'=>1,
            'quantity'=>7
        ]);

        $this->assertTrue(ShopCart::count()==0);
        $response->assertRedirect('/login');
    }


    //
    public function testCartDestroyWrongUser()
    {
        $user=\App\Models\User::factory()->create();

        $shopCart=\App\Models\ShopCart::factory()->create();
        $this->assertTrue(ShopCart::count()==1);
        
        $response = $this->actingAs($user)->call('DELETE','/cart/'.$shopCart->id);
        $this->assertTrue(ShopCart::count()==1);
        $response->assertStatus(403);

    }

    public function testCartDestroyUser()
    {
        $shopCart=\App\Models\ShopCart::factory()->create();

        $user=User::find($shopCart->user_id);

        $this->assertTrue(ShopCart::count()==1);
        
        $response = $this->actingAs($user)->call('DELETE','/cart/'.$shopCart->id);
        $this->assertTrue(ShopCart::count()==0);
        $response->assertRedirect('/cart');

    }





}
