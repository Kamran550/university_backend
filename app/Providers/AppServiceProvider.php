<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Load custom helpers
        require_once app_path('Helpers/TextHelper.php');

        $this->app->bind(
            \App\Repositories\Interfaces\FacultyRepositoryInterface::class,
            \App\Repositories\FacultyRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\DegreeRepositoryInterface::class,
            \App\Repositories\DegreeRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\ApplicationRepositoryInterface::class,
            \App\Repositories\ApplicationRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\ProgramRepositoryInterface::class,
            \App\Repositories\ProgramRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
