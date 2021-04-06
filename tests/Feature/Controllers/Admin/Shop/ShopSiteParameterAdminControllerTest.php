<?php

namespace Tests\Feature\Controllers\Admin\Shop;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\UserTrait;

use App\Models\SiteParameter as Model;


class ShopSiteParameterAdminControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;
    use UserTrait;
    private $uri='/admin/shop/site-parameters';

    private $routePath='admin.site.parameters.';

    public function testIndexRoot()
    {
        $response = 
        $this->be($this->getAdminUser($this->routePath.'index'))->
        get($this->uri);
        $response->assertStatus(200);
    }


    public function testCreate()
    {
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
                'value'=>2,
            )
        );
        $response->assertSessionHasErrors('slug');
        $response->assertStatus(302);
    }

    public function testStoreCorrect()
    {
        $entity=Model::factory()->create();
        $response=$this->be($this->getAdminUser($this->routePath.'store'))->
        call('POST',$this->uri.'/',
            array(
                'name'=>'dsf',
                'slug'=>'dsf',
                'value'=>2,
            )
        );
        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }

    public function testEdit()
    {
        $entity=Model::factory()->create();
        $response=$this->be($this->getAdminUser($this->routePath.'edit'))->
        get($this->uri.'/'.$entity->slug.'/edit');
        $response->assertSeeText($entity->name);
        $response->assertStatus(200);
    }


    public function testUpdateCorrect()
    {
        $entity=Model::factory()->create();
        $response=$this->be($this->getAdminUser($this->routePath.'update'))->
        call('PATCH',$this->uri.'/'.$entity->slug,
            array(
                'name'=>'dsf',
                'slug'=>'dffd'
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
                'name'=>'dsf',
                'parent_id'=>-1
            )
        );
        $response->assertSessionHasErrors('slug');
        $response->assertStatus(302);
    }

    public function testDestroyCorrect()
    {
        $entity=Model::factory()->create();
        
        $this->assertEquals(1,Model::count());
        $response=$this->be($this->getAdminUser($this->routePath.'destroy'))->
        call('DELETE',$this->uri.'/'.$entity->slug,[]);
        $this->assertEquals(0,Model::count());

        $response->assertRedirect(route($this->routePath.'index'));
      
    }


}
