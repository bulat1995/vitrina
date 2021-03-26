<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $createTasks = Permission::where('slug','like','%categories%')->get();
        $manager = new Role();
        $manager->name = 'Управление категориями';
        $manager->slug = 'category-editor';
        $manager->save();
        $manager->permissions()->attach($createTasks);
        $manager->save();

        $manager = new Role();
        $createTasks = Permission::all();
        $manager->name = 'Доступ к админпанели';
        $manager->slug = 'adminPanel';
        $manager->save();
        $manager->permissions()->attach($createTasks);
        $manager->save();

        $createTasks = Permission::where('slug','like','%role%')->get();
        $developer = new Role();
        $developer->name = 'Управление Ролями';
        $developer->slug = 'role-editor';
        $developer->save();
        $developer->permissions()->attach($createTasks);

    }
}
