<?php

namespace App\Providers;

use App\Models\ContactUs;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrap();

        View::composer('layout_new.partials.sidebar', function ($view) {
            $unreadContactUsCount = 0;

            if (Schema::hasTable('contact_us')) {
                $unreadContactUsCount = ContactUs::query()->unread()->count();
            }

            $view->with('unreadContactUsCount', $unreadContactUsCount);
        });
    }
}
