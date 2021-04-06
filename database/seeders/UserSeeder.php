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
        $adminPanel = Role::where('slug','adminPanel')->first();
        $user1 = new User();
        $user1->name = 'admin';
        $user1->firstName = 'FirstName';
        $user1->secondName = 'SecondName';
        $user1->email = 'hello@hello.com';
        $user1->password = bcrypt('admin347');
        $user1->save();
        $user1->roles()->attach($adminPanel);

        

    }
}
