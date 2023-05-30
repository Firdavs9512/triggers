<?php

namespace Triggers;

use Illuminate\Support\ServiceProvider;

class MysqlTriggersServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register any package routes, migrations, views, etc.
    }

    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/stubs' => database_path('triggers/stubs'),
            ], 'laravel-mysql-triggers');
    
            $this->commands([
                Console\Commands\CreateTriggerCommand::class,
            ]);
        }
    }
}