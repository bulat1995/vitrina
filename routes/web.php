<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['middleware' => ['auth',/*'role:adminPanel'*/],'prefix'=>'/admin/','namespace'=>'App\Http\Controllers\Admin'],function(){
    //Категории
    Route::resource('categories','ShopCategoryAdminController')->
            except(['show','index','create'])->
            names('admin.shop.categories');
    //Восстановление разделов
    Route::patch('categories/{id}/restore',[App\Http\Controllers\Admin\ShopCategoryAdminController::class,'restore'])->where('id', '[0-9]+')->name('admin.shop.categories.restore');
    //Просмотр разделов
    Route::get('categories/{id?}',[App\Http\Controllers\Admin\ShopCategoryAdminController::class,'show'])->where('id','[0-9]+')->name('admin.shop.categories.show');
    //Создание раздела
    Route::get('categories/{id?}/create',[App\Http\Controllers\Admin\ShopCategoryAdminController::class,'create'])->where('id','[0-9?]+')->name('admin.shop.categories.create');

    //Роли пользователей
    Route::resource('roles','RoleAdminController')->names('admin.roles');
    //права доступа
    Route::resource('permissions','PermissionAdminController')->except(['show'])->names('admin.permissions');

    //Параметры товара
    Route::resource('parameters','ShopParameterAdminController')->except(['show'])->names('admin.shop.parameters');

    //Работа с товаром
    Route::resource('products','ShopProductAdminController')->except(['create'])->names('admin.shop.products');
    //Создание раздела
    Route::get('categories/{category_id}/products',[App\Http\Controllers\Admin\ShopProductAdminController::class,'index'])->name('admin.shop.products.index');
    //Форма добавления товара
    Route::get('products/create/{id?}',[App\Http\Controllers\Admin\ShopProductAdminController::class,'create'])->where('id', '[\d]+')->name('admin.shop.products.create');
    //Форма добавления товара
    Route::post('products/store/{category_id}',[App\Http\Controllers\Admin\ShopProductAdminController::class,'store'])->name('admin.shop.products.store');

    //Ресурс фотографий продукта
    Route::resource('product/photos','ShopProductPhotoController')->only(['destroy'])->names('admin.shop.products.photos');
});

Auth::routes();

//Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
