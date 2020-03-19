<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Site;
use Illuminate\Support\Facades\Schema;

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
        //Add variables from $site array
        //Variables are accessable through all view blade files
        View::share($this->getSiteInfo());
    }
    
    protected function getSiteInfo() {
        // Get site info
        // vajag labojumus


        // Parbaudam vai datubāzē ir tabula sites, ja nav šīs tabulas crasho viss laravel un php artisan nestrādā
        if(Schema::hasTable('sites')){
            $site = Site::find(1);
            if($site) {
                $site = [
                    'siteName' => $site->name, 
                    'siteDescription' => $site->description
                ];
                return $site;
            }
        }

    }
}
