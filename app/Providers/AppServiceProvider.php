<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Site;

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
