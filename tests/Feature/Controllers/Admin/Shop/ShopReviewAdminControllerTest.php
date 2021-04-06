<?php

namespace Tests\Feature\Controllers\Admin\Shop;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Review as Model;
use Tests\Traits\UserTrait;

class ShopReviewAdminControllerTest extends TestCase
{
   use RefreshDatabase;
    use WithoutMiddleware;
    use UserTrait;
    private $uri='/admin/shop/reviews';

    private $routePath='admin.shop.reviews.';


    public function testIndex()
    {
        $entity=Model::factory()->create();
        $response=$this->be($this->getAdminUser($this->routePath.'index'))->
        get($this->uri);
        $response->assertStatus(200);

    }


    public function testEdit()
    {
        $entity=Model::factory()->create();
        $response=$this->be($this->getAdminUser($this->routePath.'edit'))->
        get($this->uri.'/'.$entity->id.'/edit');
        $response->assertSeeText($entity->name);
       // dd($response);
        $response->assertStatus(200);
    }


    public function testUpdateCorrect()
    {
        $entity=Model::factory()->create();
        $response=$this->be($this->getAdminUser($this->routePath.'update'))->
        call('PATCH',$this->uri.'/'.$entity->id,
            array(
               'review'=>'dsfc',
               'estimate'=>5,
            )
        );
        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }

    public function testUpdateWrong()
    {
        $entity=Model::factory()->create();
        $response=$this->be($this->getAdminUser($this->routePath.'update'))->
        call('PATCH',$this->uri.'/'.$entity->id,
            array(
                'regular'=>'2',
                'estimate'=>5,
            )
        );
        $response->assertSessionHasErrors('review');
        $response->assertStatus(302);
    }

    public function testDestroyCorrect()
    {
        $entity=Model::factory()->create();
        
        $this->assertEquals(1,Model::count());
        $response=$this->be($this->getAdminUser($this->routePath.'destroy'))->
        call('DELETE',$this->uri.'/'.$entity->id,[]);
        $this->assertEquals(0,Model::count());
        $response->assertSessionHas('success');
      
    }
}
