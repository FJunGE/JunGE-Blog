<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Faker\Generator as FakerGenerator;
use Faker\Factory as FakerFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //全局數組變量
        view()->share('siteName','Junge');
        view()->share('siteDescribe','是一個大帥哥');

        //本地化设置
        Carbon::setLocale('zh');

        //数据填充中文设置
        $this->app->singleton(FakerGenerator::class, function (){
            return FakerFactory::create('zh_CN');
        });
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
