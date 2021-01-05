<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleEditor = Role::where('slug','role-editor')->first();
        $user1 = new User();
        $user1->name = 'bulat1995';
        $user1->email = 'bulat1995@hello.com';
        $user1->password = bcrypt('123456');
        $user1->save();
        $user1->roles()->attach($roleEditor);

    }
}
