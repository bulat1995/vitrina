<?php

namespace Tests\Feature\Controllers\Shop;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShopProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Список товаров
     *
     * @return void
     */
    public function testIndex()
    {
        $cat=rand(0,20);
        $response = $this->get('/products/'.$cat);
        $response->assertStatus(200);
    }

    /**
     * Список товаров
     *
     * @return void
     */
    public function testShow()
    {
        $cat=rand(0,20);
        $response = $this->get('/product/'.$cat);
        $response->assertStatus(404);

        $product=\App\Models\ShopProduct::factory()->create();

        $response = $this->get('/product/'.$product->id);
        $response->assertStatus(200);
    }


}
