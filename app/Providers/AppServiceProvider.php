<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
     * Share $menuaccess globally with all views so the sidebar/navbar
     * privilege checks work on every page without each controller
     * needing to pass it manually.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            // Only run if not already set by the controller
            if (!isset($view->menuaccess)) {
                $view->with('menuaccess', $this->loadMenuAccess());
            }
        });
    }

    /**
     * Fetch the logged-in user's menu privileges.
     *
     * The DB connection can go stale after the app sits idle for a while
     * (e.g. overnight) — the first request of the day then throws a
     * "MySQL server has gone away" / "server has gone away" style
     * PDOException. Previously that exception was silently swallowed and
     * an empty privilege list was returned, which made the sidebar show
     * only the Dashboard link until the next click/reload picked up a
     * fresh connection. We now reconnect and retry once before giving up,
     * and log real failures instead of hiding them.
     */
    private function loadMenuAccess(): array
    {
        try {
            return (new Commeninfo())->Getmenuprivilege();
        } catch (\Throwable $e) {
            $message = $e->getMessage();
            $isStaleConnection = str_contains($message, 'gone away')
                || str_contains($message, 'server has gone away')
                || str_contains($message, 'Lost connection');

            if ($isStaleConnection) {
                try {
                    DB::reconnect();
                    return (new Commeninfo())->Getmenuprivilege();
                } catch (\Throwable $retryException) {
                    Log::warning('Menu privilege reload failed after DB reconnect', [
                        'error' => $retryException->getMessage(),
                    ]);
                    return [];
                }
            }

            Log::warning('Menu privilege load failed', ['error' => $message]);
            return [];
        }
    }
}
