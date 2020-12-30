<?php

namespace App\Observers;

use App\Models\Role;

class RoleObserver
{

    public function creating(Role $role)
    {
        unset($role->permissions_id);
    }

    /**
     * Handle the Role "created" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function created(Role $role)
    {
        $data=request()->input();
        $role->permissions()->attach($data['permissions_id']);
    }

    /**
     * Handle the Role "updated" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function updating(Role $role)
    {
        $role->permissions()->detach();
        $data=request()->input();
        $role->permissions()->attach($role->permissions_id);
        unset($role->permissions_id);
    }

    /**
     * Handle the Role "deleted" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function deleted(Role $role)
    {
        //
    }

    /**
     * Handle the Role "restored" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function restored(Role $role)
    {
        //
    }

    /**
     * Handle the Role "force deleted" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function forceDeleted(Role $role)
    {
        //
    }
}
