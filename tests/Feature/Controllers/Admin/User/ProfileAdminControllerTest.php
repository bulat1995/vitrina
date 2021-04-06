<?php

namespace Tests\Feature\Controllers\Admin\User;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\UserTrait;

use App\Models\User as Model;
class ProfileAdminControllerTest extends TestCase
{
 use RefreshDatabase;
    use WithoutMiddleware;
    use UserTrait;
    private $uri='/admin/users/profiles';

    private $routePath='admin.profiles.';

    public function testIndex()
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
    public function testShow()
    {
        $entity=Model::factory()->create();
        $response = 
        $this->be($this->getAdminUser($this->routePath.'show'))->
        get($this->uri.'/'.$entity->id);
        $response->assertStatus(200);
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
                'firstName'=>'dsfc',
                'secondName'=>'dsfc',
                'address'=>'dsfc',
                'birthday'=>'2020-02-02',
                'roles'=>\App\Models\Role::factory()->create()->id,
                'email'=>'dsfc@mi.ru',
            )
        );
        //dd($response);
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
        $response->assertSessionHasErrors('firstName');
        $response->assertStatus(302);
    }

    public function testDestroyCorrect()
    {
        $entity=Model::factory()->create();
        $this->assertEquals(1,Model::count());
        $response=$this->be($this->getAdminUser($this->routePath.'destroy'))->
        call('DELETE',$this->uri.'/'.$entity->id,[]);
        //dd($response);
        //$this->assertEquals(0,Model::count());
        $response->assertSessionHas('success');
        $response->assertRedirect(route($this->routePath.'index'));
    }


}
