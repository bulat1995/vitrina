<?php
namespace App\Observers;

trait RolesPermissionsTraitObserver
{


    /*
        Обновление ключей доступа роли или пользователя
    */
    private function refreshPermissions($obj)
    {
        if(!empty($obj->id) && isset($user->roles)){
                $obj->permissions()->detach();
                $obj->permissions()->attach($obj->permissionsId);
        }
        unset($obj->permissionsId);
        return $obj;
    }

    /*
        Обновление ролей пользователя
    */
    private function refreshRoles($user)
    {
        if($user->isDirty('roles') && isset($user->roles)){
            $user->roles()->detach();
            $user->roles()->attach($user->roles);
        }
        unset($user->roles);
        return $user;
    }

}
