<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Slider::factory(10)->create();
       
        \App\Models\ShopParameter::factory(18)->create();
        $this->call(ShopCategorySeeder::class);
        \App\Models\ShopCategory::factory(10)->create();
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        \App\Models\User::factory(10)->create();
        $this->call(StaticPageSeeder::class);
        $this->call(SiteParameterSeeder::class);
        \App\Models\Message::factory(2)->create();
        \App\Models\ShopProduct::factory(2)->create();
        \App\Models\ShopProductPhoto::factory(2)->create();
        \App\Models\Review::factory(4)->create();
    }
}
