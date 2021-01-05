<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;


use App\Models\ShopCategory;
use App\Models\ShopProduct;
use App\Models\Role;

use App\Observers\ShopCategoryObserver;
use App\Observers\ShopProductObserver;
use App\Observers\RoleObserver;


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
    }
}
