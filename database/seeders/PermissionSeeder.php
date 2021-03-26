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
            'admin.roles.destroy'=>array('name'=>'Роль пользователя','action'=>'Удаление','changeable'=>0),

            //Профиль пользователей
            'admin.profiles.show'=>array('name'=>'Профиль пользователя','action'=>'Просмотр','changeable'=>0),
            'admin.profiles.create'=>array('name'=>'Профиль пользователя','action'=>'Добавление','changeable'=>0),
            'admin.profiles.edit'=>array('name'=>'Профиль пользователя','action'=>'Редактирование','changeable'=>0),
            'admin.profiles.destroy'=>array('name'=>'Профиль пользователя','action'=>'Удаление','changeable'=>0),
            'admin.profiles.deleteavatar'=>array('name'=>'Профиль пользователя','action'=>'Удаление Аватарки','changeable'=>0),

            //Статические страницы
            'admin.pages.show'=>array('name'=>'Статические страницы','action'=>'Просмотр','changeable'=>0),
            'admin.pages.create'=>array('name'=>'Статические страницы','action'=>'Добавление','changeable'=>0),
            'admin.pages.edit'=>array('name'=>'Статические страницы','action'=>'Редактирование','changeable'=>0),
            'admin.pages.destroy'=>array('name'=>'Статические страницы','action'=>'Удаление','changeable'=>0),


            //Параметры сайта
            'admin.site.parameters.show'=>array('name'=>'Параметры сайта','action'=>'Просмотр','changeable'=>0),
            'admin.site.parameters.create'=>array('name'=>'Параметры сайта','action'=>'Добавление','changeable'=>0),
            'admin.site.parameters.edit'=>array('name'=>'Параметры сайта','action'=>'Редактирование','changeable'=>0),
            'admin.site.parameters.destroy'=>array('name'=>'Параметры сайта','action'=>'Удаление','changeable'=>0),

            //Сообщения
            'admin.messages.show'=>array('name'=>'Сообщения','action'=>'Просмотр','changeable'=>0),
            'admin.messages.create'=>array('name'=>'Сообщения','action'=>'Добавление','changeable'=>0),
            'admin.messages.edit'=>array('name'=>'Сообщения','action'=>'Редактирование','changeable'=>0),
            'admin.messages.destroy'=>array('name'=>'Сообщения','action'=>'Удаление','changeable'=>0),

            //Сообщения
            'admin.shop.sliders.show'=>array('name'=>'Слайдеры','action'=>'Просмотр','changeable'=>0),
            'admin.shop.sliders.create'=>array('name'=>'Слайдеры','action'=>'Добавление','changeable'=>0),
            'admin.shop.sliders.edit'=>array('name'=>'Слайдеры','action'=>'Редактирование','changeable'=>0),
            'admin.shop.sliders.destroy'=>array('name'=>'Слайдеры','action'=>'Удаление','changeable'=>0),

            //Поиск по админпанели
            'admin.search'=>array('name'=>'Поиск по сайту','action'=>'Разрешить','changeable'=>0),


            //Сообщения
            'admin.shop.reviews.show'=>array('name'=>'Отзывы','action'=>'Просмотр','changeable'=>0),
            'admin.shop.reviews.create'=>array('name'=>'Отзывы','action'=>'Добавление','changeable'=>0),
            'admin.shop.reviews.edit'=>array('name'=>'Отзывы','action'=>'Редактирование','changeable'=>0),
            'admin.shop.reviews.destroy'=>array('name'=>'Отзывы','action'=>'Удаление','changeable'=>0),
            

            //Просмотр корзины
            'admin.shop.carts.show'=>array('name'=>'Корзина','action'=>'Просмотр','changeable'=>0),



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
