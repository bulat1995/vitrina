<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FileManagerService;

class FileManagerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        return $this->app->singleton('FileManagerService',function(){
            return new FileManagerService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
