<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use App\Exceptions\ModelNotExistException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('firstOrFailToJson', function($message = 'Model not found'){
            if ($this->first()) {
                return $this->first();
            }

            throw new ModelNotExistException($message);
        });
    }
}
