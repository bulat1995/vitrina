<?php

namespace Tests\Feature\Controllers\Admin\Shop;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShopCartAdminControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->withoutMiddleware();
        $user=$this->getAdminUser('admin.shop.carts.show');
        $carts=\App\Models\ShopCart::factory(1)->create();
        $response = $this->actingAs($user)->
                get('/admin/shop/carts');

        $response->assertStatus(200);

    }
}
