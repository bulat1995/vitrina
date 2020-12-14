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


Route::group(['prefix'=>'/admin/','namespace'=>'App\Http\Controllers\Shop\Admin'],function(){
    Route::resource('category','ShopCategoryAdminController')->names('admin.shop.categories');
    Route::patch('category/{id}/restore',[App\Http\Controllers\Shop\Admin\ShopCategoryAdminController::class,'restore'])->where('id', '[0-9]+')->name('admin.shop.categories.restore');
});

Auth::routes();

//Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
