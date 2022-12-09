<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use App\Models\Language;
use App\Models\Page;
use App\Models\SectionData;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
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
        view()->share('general', GeneralSetting::first());
        view()->share('pages', Page::where('status',1)->where('is_dropdown',0)->orderBy('page_order','ASC')->get());
        view()->share('dropdown', Page::where('status',1)->where('is_dropdown',1)->orderBy('page_order','ASC')->get());
        view()->share('contact', SectionData::where('key', 'contact.content')->first());
        view()->share('socials', SectionData::where('key', 'social.element')->get());
        view()->share('navbar', json_decode(file_get_contents(resource_path('lang/navbar.json')), true));
        view()->share('website', json_decode(file_get_contents(resource_path('lang/website.json')), true));



        Blade::directive('changeLang', function ($key) {

            Artisan::call('view:clear');
            $key = ucwords(trim(str_replace('\'', '', $key)));
            $navbar = json_decode(file_get_contents(resource_path('lang/navbar.json')), true);
            $website = json_decode(file_get_contents(resource_path('lang/website.json')), true);


            if (array_key_exists($key, $navbar)) {
                return "{$navbar[$key]}";
            } elseif (array_key_exists($key, $website)) {
                return "{$website[$key]}";
            }

            $key = $key;
            $website[$key] = $key;
            file_put_contents(resource_path('lang/website.json'), json_encode($website));
            return $key;
        });
    }
}
