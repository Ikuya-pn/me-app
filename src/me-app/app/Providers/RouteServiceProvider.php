<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    private const HOME = '/dashboard';

    public static function home(){
        $role = detect_role();
        if(empty($role)){
            return self::HOME;
        }elseif($role == 'worker'){
            return '/' . $role . '/' . 'works';
        }else{
            return '/' . $role;
        }
    }

    // public static function home() {
    //     $role = detect_role();
    //     return empty($role) ? self::HOME : '/' . $role . self::HOME;
    // }

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            $role = detect_role();
            return Limit::perMinute(60)->by($request->user($role)?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
