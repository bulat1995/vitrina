<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;


use App\Models\ShopCategory;
use App\Models\ShopProduct;
use App\Models\Role;
use App\Models\User;
use App\Models\Slider;

use App\Observers\ShopCategoryObserver;
use App\Observers\ShopProductObserver;
use App\Observers\RoleObserver;
use App\Observers\ProfileAdminObserver;
use App\Observers\SliderAdminObserser;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Role::observe(RoleObserver::class);
        ShopCategory::observe(ShopCategoryObserver::class);
        ShopProduct::observe(ShopProductObserver::class);
        User::observe(ProfileAdminObserver::class);
        Slider::observe(SliderAdminObserser::class);
    }
}
