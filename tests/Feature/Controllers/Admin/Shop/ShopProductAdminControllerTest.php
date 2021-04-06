<?php

namespace Tests\Feature\Controllers\Admin\Shop;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\UserTrait;

use App\Models\ShopProduct as Model;

class ShopProductAdminControllerTest extends TestCase
{
   use RefreshDatabase;
    use WithoutMiddleware;
    use UserTrait;
    private $uri='/admin/shop/products';

    private $routePath='admin.shop.products.';



    public function testCreate()
    {
        $entity=Model::factory()->create();
        //dd($entity);
        $response=$this->be($this->getAdminUser($this->routePath.'create'))->
        get($this->uri.'/create/'.$entity->category_id);
       // dd($response);
        $response->assertStatus(200);
    }


    public function testShow()
    {
        $entity=Model::factory()->create();
        $response = 
        $this->be($this->getAdminUser($this->routePath.'show'))->
        get($this->uri.'/'.$entity->id);
        //dd($response);
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
        $response->assertSessionHasErrors('price');
        $response->assertStatus(302);
    }

    public function testStoreCorrect()
    {
        $entity=Model::factory()->create();
        $response=$this->be($this->getAdminUser($this->routePath.'store'))->
        call('POST',$this->uri.'/store/'.$entity->category_id,
            array(
                'name'=>'dsfc',
                'price'=>2,
                
            )
        );
        $response->assertSessionHas('success');
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


    public function testUpdateCorrect()
    {
        $entity=Model::factory()->create();
        $response=$this->be($this->getAdminUser($this->routePath.'update'))->
        call('PATCH',$this->uri.'/'.$entity->id,
            array(
               'name'=>'dsfc',
                'price'=>2,
            )
        );
        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }

    public function testUpdateWrong()
    {
        $entity=Model::factory()->create();
        $response=$this->be($this->getAdminUser($this->routePath.'update'))->
        call('PATCH',$this->uri.'/1',
            array(
                'regular'=>'2',
                'rating'=>20,
                'required'=>true,
                'inputType'=>'digit',
            )
        );
        $response->assertSessionHasErrors('name');
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
