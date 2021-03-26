<?php

namespace App\Observers;

use App\Models\Role;
use App\Observers\RolesPermissionsTraitObserver;

class RoleObserver
{
    use RolesPermissionsTraitObserver;

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


}
