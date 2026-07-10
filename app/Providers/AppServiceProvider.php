<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Commeninfo;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            // Only run if not already set by the controller
            if (!isset($view->menuaccess)) {
                try {
                    $menuaccess = (new Commeninfo())->Getmenuprivilege();
                } catch (\Exception $e) {
                    $menuaccess = [];
                }
                $view->with('menuaccess', $menuaccess);
            }
        });
    }
}
