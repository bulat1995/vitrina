<?php

namespace Tests\Feature\Controllers\Admin\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\UserTrait;

use App\Models\Permission as Model;

class PermissionAdminControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;
    use UserTrait;
    private $uri='/admin/users/permissions';

    private $routePath='admin.permissions.';

    public function testIndexRoot()
    {
        $response = 
        $this->be($this->getAdminUser($this->routePath.'index'))->
        get($this->uri);
        $response->assertStatus(200);
    }

    /*/
     *
     * @return void
     */
    public function testShowRoot()
    {
        $response = 
        $this->be($this->getAdminUser($this->routePath.'index'))->
        get($this->uri);
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
        call('POST',$this->uri,
            array(
                'name'=>'dsfc',
                'slug'=>'2sdfsdf',
                'action_name'=>'20sdfsdf',
                
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
        call('PATCH',$this->uri.'/1',
            array(
                 'name'=>'dsfc',
                'slug'=>'2fsfdsdf',
                'action_name'=>'20sdfsdf',
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
                'slug'=>'2',
                'action_name'=>20,
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
        call('DELETE',$this->uri.'/1',[]);
        $this->assertEquals(0,Model::count());
        $response->assertRedirect(route($this->routePath.'index'));
    }


}

