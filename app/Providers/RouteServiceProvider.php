<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();



        $this->mapShopssRoutes();

        $this->mapShopRoutes();


        $this->mapAdminRoutes();

        //
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::group([
            'middleware' => ['web', 'admin', 'auth:admin'],
            'prefix' => 'admin',
            'as' => 'admin.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/admin.php');
        });
    }

    /**
     * Define the "employee" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapEmployeeRoutes()
    {
        Route::group([
            'middleware' => ['web', 'employee', 'auth:employee'],
            'prefix' => 'employee',
            'as' => 'employee.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/employee.php');
        });
    }

    /**
     * Define the "shop" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapShopRoutes()
    {

        Route::group([
            'middleware' => ['web', 'shop', 'auth:shop'],
            'prefix' => 'shop',
            'as' => 'shop.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/shop.php');
        });
    }

    /**
     * Define the "shopss" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapShopssRoutes()
    {
        Route::group([
            'middleware' => ['web', 'shopss', 'auth:shopss'],
            'prefix' => 'shopss',
            'as' => 'shopss.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/shopss.php');
        });
    }

    /**
     * Define the "deliveryman" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapDeliverymanRoutes()
    {
        // Route::group([
        //     'middleware' => ['web', 'deliveryman', 'auth:deliveryman'],
        //     'prefix' => 'deliveryman',
        //     'as' => 'deliveryman.',
        //     'namespace' => $this->namespace,
        // ], function ($router) {
        //     require base_path('routes/deliveryman.php');
        // });
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
//dd($this->namespace)
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)

             ->group(base_path('routes/api.php'));
    }
}
