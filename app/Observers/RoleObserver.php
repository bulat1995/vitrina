<?php

namespace App\Observers;

use App\Models\Role;

class RoleObserver
{

    /**
     * Обработка перед созданием
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function creating(Role $role)
    {
        unset($role->permissionsId);
    }

    /**
     * обработка после создания
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function created(Role $role)
    {
        $role=$this->refreshPermissions($role);
    }


    /**
     * обработка перед обновлением
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function updating(Role $role)
    {
        $role=$this->refreshPermissions($role);
    }

    /*
        Обновление ключей доступа роли
    */
    private function refreshPermissions(Role $role)
    {
        unset($role->permissionsId);
        $permissions=request()->route()->permissionsId;
        if(!empty($role->id)){
            $role->permissions()->detach();
            $role->permissions()->attach($permissions);
        }
        return $role;
    }
}
