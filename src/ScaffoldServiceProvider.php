<?php

namespace Jotapegue\Scaffold;

use Illuminate\Support\ServiceProvider;
use Jotapegue\Scaffold\Console\Commands\ScaffoldCommand;

class ScaffoldServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ScaffoldCommand::class,
            ]);
        }
    }

    public function register()
    {
        // 
    }
}