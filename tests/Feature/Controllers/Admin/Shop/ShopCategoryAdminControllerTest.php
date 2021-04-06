<?php

namespace Tests\Feature\Controllers\Admin\Shop;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\ShopCategory as Model;

class ShopCategoryAdminControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    private $uri='/admin/shop/categories';

    private $routePath='admin.shop.categories.';

    /**
     * Корневая категория
     *
     * @return void
     */
    public function testShowRoot()
    {
        $response = 
        $this->be($this->getAdminUser($this->routePath.'show'))->
        get($this->uri.'');
        $response->assertSeeText('Корневая категория');
        $response->assertStatus(200);
    }

    /**
     * Рандомная категория
     *
     * @return void
     */
    public function testShow()
    {
        $category=Model::factory()->create();
        $response = 
        $this->be($this->getAdminUser($this->routePath.'show'))->
        get($this->uri.'/1');
        $response->assertSeeText($category->name);
        $response->assertStatus(200);
    }


    public function testCreate()
    {
        $category=Model::factory()->create();
        $response=$this->be($this->getAdminUser($this->routePath.'create'))->
        get($this->uri.'/0/create');
      //dd($response);
        $response->assertStatus(200);
    }


    public function testStoreWrong()
    {

        $response=$this->be($this->getAdminUser($this->routePath.'store'))->
        call('POST',$this->uri.'/',
            array(
                'name'=>'dsf',
                'parent_id'=>2,
            )
        );
       // dd($response);
        $response->assertSessionHasErrors('parent_id');
        $response->assertStatus(302);
    }

    public function testStoreCorrect()
    {
        $category=Model::factory()->create();
        $response=$this->be($this->getAdminUser($this->routePath.'store'))->
        call('POST',$this->uri.'/',
            array(
                'name'=>'dsf',
                'parent_id'=>1
            )
        );
        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }

    public function testEdit()
    {
        $category=Model::factory()->create();
        $response=$this->be($this->getAdminUser($this->routePath.'edit'))->
        get($this->uri.'/1/edit');
        $response->assertSeeText($category->name);
        $response->assertStatus(200);
    }


    public function testUpdateCorrect()
    {
        $category=Model::factory()->create();
        $response=$this->be($this->getAdminUser($this->routePath.'update'))->
        call('PATCH',$this->uri.'/1',
            array(
                'name'=>'dsf',
                'parent_id'=>0
            )
        );
        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }

    public function testUpdateWrong()
    {
        $category=Model::factory()->create();
        $response=$this->be($this->getAdminUser($this->routePath.'update'))->
        call('PATCH',$this->uri.'/1',
            array(
                'name'=>'dsf',
                'parent_id'=>-1
            )
        );
        $response->assertSessionHasErrors('parent_id');
        $response->assertStatus(302);
    }

    public function testDestroyCorrect()
    {
        $category=Model::factory()->create();
        
        $this->assertEquals(1,Model::count());
        $response=$this->be($this->getAdminUser($this->routePath.'destroy'))->
        call('DELETE',$this->uri.'/1',[]);
        $this->assertEquals(0,Model::count());

        $response->assertRedirect(route($this->routePath.'show',$category->parent_id));
      
    }


}
