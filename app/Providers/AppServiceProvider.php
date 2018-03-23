<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Notification;
use App\Konfigurasi;
use App\Setting;
use App\Menu;
use Schema;
use View;
// use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        View::share('_web', Setting::web());
        $font = Setting::fontType();
        if($font == 'ucword')
            $font = 'text-capitalize';
        if($font == 'uppercase')
            $font = 'text-uppercase';
        if($font == 'lowercase')
            $font = 'text-lowercase';
        View::share('_font_type', $font);
        $menu = Menu::with('sm')->where('primary_menu', null)->orderBy('position')->get();
        View::share('_menu', $menu);
        View::share('_ck', \App\ContentKind::data());
        View::share('_pk', \App\PageKind::all());
        View::share('_fk', \App\FeedBackKind::all());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
