<?php

namespace Tests\Feature\Controllers\Admin\Shop;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Slider as Model;
use Tests\Traits\UserTrait;

class ShopSliderAdminControllerTest extends TestCase
{
   use RefreshDatabase;
    use WithoutMiddleware;
    use WithFaker;
    use UserTrait;
    private $uri='/admin/shop/sliders';

    private $routePath='admin.shop.sliders.';



    public function testIndex()
    {
       $response=$this->be($this->getAdminUser($this->routePath.'create'))->
        get($this->uri.'/');
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $entity=Model::factory()->create();
        $response=$this->be($this->getAdminUser($this->routePath.'create'))->
        get($this->uri.'/create');
        $response->assertStatus(200);
    }



    public function testStoreWrong()
    {
        $response=$this->be($this->getAdminUser($this->routePath.'store'))->
        call('POST',$this->uri.'/',
            array(
                'name'=>'dsf',
            )
        );
        $response->assertSessionHasErrors('title');
        $response->assertStatus(302);
    }

   
    public function testEdit()
    {
        $entity=Model::factory()->create();
        $response=$this->be($this->getAdminUser($this->routePath.'edit'))->
        get($this->uri.'/'.$entity->id.'/edit');
        $response->assertSeeText($entity->name);
        $response->assertStatus(200);
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
