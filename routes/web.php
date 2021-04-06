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


Route::group(['middleware'=>['language'],'prefix'=>'/'],function(){

    /*******************************************************
                    
                    Панель управления 

    *******************************************************/
    Route::group(['middleware' => ['auth','role:adminPanel'],'prefix'=>'admin','namespace'=>'App\Http\Controllers\Admin\\'],function(){
        //Подраздел для витрины
        Route::group(['prefix'=>'shop','namespace'=>'Shop'],function(){


            //Категории
            Route::resource('categories','ShopCategoryAdminController')->except(['show','index','create'])->names('admin.shop.categories');
            //Восстановление разделов
            Route::patch('categories/{id}/restore',[App\Http\Controllers\Admin\Shop\ShopCategoryAdminController::class,'restore'])->where('id', '[0-9]+')->name('admin.shop.categories.restore');
            //Просмотр разделов
            Route::get('categories/{id?}',[App\Http\Controllers\Admin\Shop\ShopCategoryAdminController::class,'show'])->where('id','[0-9]+')->name('admin.shop.categories.show');
            //Создание раздела
            Route::get('categories/{id?}/create',[App\Http\Controllers\Admin\Shop\ShopCategoryAdminController::class,'create'])->where('id','[0-9?]+')->name('admin.shop.categories.create');


            //Параметры товара
            Route::resource('parameters','ShopParameterAdminController')->except(['show'])->names('admin.shop.parameters');
            //Работа с товаром
            Route::resource('products','ShopProductAdminController')->except(['create','index'])->names('admin.shop.products');
            //  Создание раздела
            // Route::get('categories/{category_id}/products',[App\Http\Controllers\Admin\Shop\ShopProductAdminController::class,'index'])->name('admin.shop.products.index');
            //Форма добавления товара
            Route::get('products/create/{id?}',[App\Http\Controllers\Admin\Shop\ShopProductAdminController::class,'create'])->where('id', '[\d]+')->name('admin.shop.products.create');
            //добавление товара
            Route::post('products/store/{category_id}',[App\Http\Controllers\Admin\Shop\ShopProductAdminController::class,'store'])->name('admin.shop.products.store');
            //фотографий продукта
            Route::resource('product/photos','ShopProductPhotoAdminController')->only(['destroy'])->names('admin.shop.products.photos');
            

            //Параметры для шаблона витрины
            Route::resource('site-parameters','ShopSiteParametersAdminController')->except(['show'])->names('admin.site.parameters');


            //Работа  со слайдером
            Route::resource('sliders','ShopSliderAdminController',['except'=>['show']])->names('admin.shop.sliders');
           

            //Статические страницы
            Route::resource('static-pages','ShopStaticPageAdminController')->names('admin.pages');

            Route::redirect('/','shop/categories');


            //Отзывы
            Route::resource('reviews','ShopReviewAdminController')->except(['create','store','show'])->names('admin.shop.reviews');

            //Корзинки пользователей
            Route::resource('carts','ShopCartAdminController')->only(['index'])->names('admin.shop.carts');

        });


        Route::group(['prefix'=>'users','namespace'=>'User'],function(){
            //Роли пользователей
            Route::resource('roles','RoleAdminController')->names('admin.roles');
            //права доступа
            Route::resource('permissions','PermissionAdminController')->except(['show'])->names('admin.permissions');

            //Работа с пользователями
            Route::delete('profiles/{user_id}/deleteAvatar/',[App\Http\Controllers\Admin\User\ProfileAdminController::class,'deleteAvatar'])->name('admin.profiles.deleteAvatar');
            Route::resource('profiles','ProfileAdminController')->names('admin.profiles');

            //Сообщения пользователей
            Route::resource('messages','MessageAdminController')->names('admin.messages');

        });

        //Поиск по сайту
        Route::post('search',[App\Http\Controllers\Admin\SearchAdminController::class,'simpleSearch'])->name('admin.search');

        Route::redirect('/','shop/categories');
    });



    Auth::routes();



    /*******************************************************
                    
                    Фасадная часть сайта 

    *******************************************************/
    //Главная страница
    Route::get('/', [App\Http\Controllers\Shop\ShopMainPageController::class, 'index'])->name('shop');


    //Список товаров в категории
    Route::get('/products/{category}',[App\Http\Controllers\Shop\ShopProductController::class,'index'])->where('category', '[A-z0-9\-]+')->name('shop.products');
    //Описание товара
    Route::get('/product/{id}',[App\Http\Controllers\Shop\ShopProductController::class,'show'])->where('id', '[0-9]+')->name('shop.product');
    //Модуль поиска
    Route::get('/search/',[App\Http\Controllers\Shop\ShopSearchController::class,'index'])->name('shop.search');
    
    //Сообщения пользователя с администратором
    Route::resource('/messages', 'App\Http\Controllers\Shop\ShopMessageController')->except(['show'])->names('shop.messages');
    //Отзывы пользователя о товарах
    Route::resource('/reviews', 'App\Http\Controllers\Shop\ShopReviewController')->except(['show'])->names('shop.reviews');
    //Корзина пользователя
    Route::resource('/cart','App\Http\Controllers\Shop\ShopCartController')->only(['index','store','destroy'])->names('shop.cart');
    //Профиль пользователя
    Route::resource('profile','App\Http\Controllers\Shop\ShopProfileController')->only(['index','edit','update'])->names('shop.profile');
    //Модуль поиска
    Route::delete('profile/deleteAvatar',[App\Http\Controllers\Shop\ShopProfileController::class,'deleteAvatar'])->name('shop.profile.deleteAvatar');

    //Статическая страница
    Route::get('{page}',[App\Http\Controllers\Shop\ShopStaticPageController::class,'show'])->where('page', '[A-z0-9\-]+')->name('shop.page');


    //Смена локализации
    Route::get('/language/{lang}',function($id){
        if(array_key_exists($id,config('my.global.language.list'))){
            session(['user_language'=>$id]);
        }
        return redirect()->route('shop');
    })->name('language');
});
