<?php

namespace App\Providers;

use App\Models\Organization\Lodge;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            Lodge::IMAGE_TOKEN => Lodge::class,
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->afterResolving('migrator', function ($migrator) {
            $migrator->path(database_path('migrations/parse_hostel'));
        });
    }
}
