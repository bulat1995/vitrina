<?php

namespace Tests\Feature\Controllers\Shop;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShopReviewControllerTest extends TestCase
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
                    ->get('/reviews');
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGuest()
    {
        $response = $this->get('/reviews');
        $response->assertRedirect("/login");
    }


    public function testIndex()
    {
        $user=\App\Models\User::factory()->create();
        $response=$this->actingAs($user)
                ->get('/reviews');
        $response->assertStatus(200);
    }


    public function testStoreSuccess()
    {
        $user=\App\Models\User::factory()->create();
        $product=\App\Models\ShopProduct::factory()->create();

        $response=$this->actingAs($user)
                ->call('POST','/reviews',[
                    'product_id'=>$product->id,
                    'review'=>'sadfasdfasdfasd',
                    'estimate'=>1,
                ]);
        $response->assertSessionHas('success');
    }

    public function testStoreWrong()
    {
        $user=\App\Models\User::factory()->create();
        $product=\App\Models\ShopProduct::factory()->create();

        $response=$this->actingAs($user)
                ->call('POST','/reviews',[
                    'product_id'=>$product->id,
                    'review'=>'sadfasdfasdfasd',
                ]);
        $response->assertSessionHasErrors('estimate');
    }


    public function testDestroySuccess()
    {
        $review=\App\Models\Review::factory()->create();
        $user=\App\Models\User::find($review->user_id);

        $response=$this->actingAs($user)
                ->call('DELETE','/reviews/'.$review->id,[]);
        $response->assertSessionHas('success');
    }
}
