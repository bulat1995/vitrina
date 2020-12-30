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



Route::group(['middleware' => ['auth','role:adminPanel'],'prefix'=>'/admin/','namespace'=>'App\Http\Controllers\Admin'],function(){
    //Категории
    Route::resource('categories','ShopCategoryAdminController')->
            except(['show','index'])->
            names('admin.shop.categories');
    //Восстановление разделов
    Route::patch('categories/{id}/restore',[App\Http\Controllers\Admin\ShopCategoryAdminController::class,'restore'])->where('id', '[0-9]+')->name('admin.shop.categories.restore');
    //Просмотр разделов
    Route::get('categories/{id?}',[App\Http\Controllers\Admin\ShopCategoryAdminController::class,'show'])->where('id','[0-9]+')->name('admin.shop.categories.show');


    //Роли пользователей
    Route::resource('roles','RoleAdminController')->names('admin.roles');
    //права доступа
    Route::resource('permissions','PermissionAdminController')->except(['show'])->names('admin.permissions');

});

Auth::routes();

//Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
