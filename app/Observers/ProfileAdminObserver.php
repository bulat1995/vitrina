<?php

namespace App\Observers;

use App\Models\User;
use App\Observers\RolesPermissionsTraitObserver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
class ProfileAdminObserver
{
    use RolesPermissionsTraitObserver;

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updating(User $user)
    {
        $user=$this->avatarLoad($user);
        $password=request()->input('password');
        if(!empty($password))
        {
            $user->password=Hash::make($password);
        }
        $user=$this->refreshPermissions($user);
        $user=$this->refreshRoles($user);

    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {

        $fileManager=app('FileManagerService');
      
        $fileManager->deleteFile($user->avatar,config('my.user.folderName'));
    }


    private function avatarLoad($user)
    {
        $avatar=request()->file('avatar');
        
        if(!empty($avatar)){
            $fileManager=app('FileManagerService');
            $fileManager->deleteFile($user->avatar,config('my.user.folderName'));
            $user->avatar=$fileManager->upload($avatar,config('my.user.folderName'));
        }
        
        return $user;
    }

}
