<?php

namespace Tests\Feature\Controllers\Admin\Shop;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\UserTrait;
use App\Models\StaticPage as Model;

class ShopStaticPageAdminControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;
    use UserTrait;


    private $uri='/admin/shop/static-pages';

    private $routePath='admin.shop.staic-pages.';


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
                'title'=>'required|min:3',
                'slug'=>'required|unique:static_pages,slug',
                'category'=>\App\Models\ShopCategory::factory()->create()->id,
                'rating'=>'22',
                'in_menu'=>true,
                'content'=>'min:3',
                'describe'=>'min:3',
                'show_user'=>true,
                'can_comment'=>true,
                'can_index'=>true,
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
        
        $response->assertSessionHasErrors('title');
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