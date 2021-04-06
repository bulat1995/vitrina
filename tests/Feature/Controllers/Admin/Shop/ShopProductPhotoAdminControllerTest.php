<?php

namespace Tests\Feature\Controllers\Admin\Shop;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShopProductPhotoAdminControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDestroy()
    {
        \App\Models\ShopProduct::factory()->create();
        $photo=\App\Models\ShopProductPhoto::factory()->create();

        $this->assertEquals(1,\App\Models\ShopProductPhoto::count());
        $response = $this->call('DELETE','/admin/shop/product/photos/'.$photo->id,[]);

        $this->assertEquals(0,\App\Models\ShopProductPhoto::count());
        $response->assertStatus(302);
    }
}
