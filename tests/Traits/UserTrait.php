<?php
namespace Tests\Traits;

use App\Models\Role;
use App\Models\User;

trait UserTrait
{
	

    public function getAdminUser($roleName='admin')
    {
    	$role=new Role();
    	$role->slug=$roleName;
        $role->name='test';
    	$role->save();
    	$user=\App\Models\User::factory()->create();
    	$user->save();
    	return $user;
    }
}