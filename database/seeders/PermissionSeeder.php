<?php

namespace Database\Seeders;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions=array(
            //Категории
            'admin.shop.categories.show'=>array('name'=>'Категория','action'=>'Просмотр','changeable'=>0),
            'admin.shop.categories.create'=>array('name'=>'Категория','action'=>'Добавление','changeable'=>0),
            'admin.shop.categories.edit'=>array('name'=>'Категория','action'=>'Редактирование','changeable'=>0),
            'admin.shop.categories.destroy'=>array('name'=>'Категория','action'=>'Удаление','changeable'=>0),

            //Продукт
            'admin.shop.products.show'=>array('name'=>'Продукт','action'=>'Просмотр','changeable'=>0),
            'admin.shop.products.create'=>array('name'=>'Продукт','action'=>'Добавление','changeable'=>0),
            'admin.shop.products.edit'=>array('name'=>'Продукт','action'=>'Редактирование','changeable'=>0),
            'admin.shop.products.destroy'=>array('name'=>'Продукт','action'=>'Удаление','changeable'=>0),
            'admin.shop.products.photos.destroy'=>array('name'=>'Фотографии продукта','action'=>'Удаление','changeable'=>0),


            //Параметры продукта
            'admin.shop.parameters.show'=>array('name'=>'Параметры Продукта','action'=>'Просмотр','changeable'=>0),
            'admin.shop.parameters.create'=>array('name'=>'Параметры Продукта','action'=>'Добавление','changeable'=>0),
            'admin.shop.parameters.edit'=>array('name'=>'Параметры Продукта','action'=>'Редактирование','changeable'=>0),
            'admin.shop.parameters.destroy'=>array('name'=>'Параметры Продукта','action'=>'Удаление','changeable'=>0),

            //Ключи доступа
            'admin.permissions.show'=>array('name'=>'Ключи доступа','action'=>'Просмотр','changeable'=>0),
            'admin.permissions.create'=>array('name'=>'Ключи доступа','action'=>'Добавление','changeable'=>0),
            'admin.permissions.edit'=>array('name'=>'Ключи доступа','action'=>'Редактирование','changeable'=>0),
            'admin.permissions.destroy'=>array('name'=>'Ключи доступа','action'=>'Удаление','changeable'=>0),

            //Роли пользователей
            'admin.roles.show'=>array('name'=>'Роль пользователя','action'=>'Просмотр','changeable'=>0),
            'admin.roles.create'=>array('name'=>'Роль пользователя','action'=>'Добавление','changeable'=>0),
            'admin.roles.edit'=>array('name'=>'Роль пользователя','action'=>'Редактирование','changeable'=>0),
            'admin.roles.destroy'=>array('name'=>'Роль пользователя','action'=>'Удаление','changeable'=>0)
        );
        
        foreach($permissions as $key=>$value)
        {
            $manageUser = new Permission();
            $manageUser->name = $value['name'];
            $manageUser->action_name = $value['action'];
            $manageUser->slug = $key;
            $manageUser->changeable = $value['changeable'];
            $manageUser->save();
        }
    }
}
