<?php

namespace Tests\Feature\Controllers\Shop;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShopSearchControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {

        $product=\App\Models\ShopProduct::factory()->create();

        $response = $this->call('GET','/search',[
            'searchValue'=>$product->name,
        ]);
        $response->assertStatus(302);

        $response = $this->call('GET','/search',[
            'search'=>$product->name,
        ]);
        $response->assertStatus(200);

        $response->assertSeeText($product->name);
    }
}
