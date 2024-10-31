<?php

namespace SchemaGen;

use Illuminate\Support\ServiceProvider;
use SchemaGen\Commands\GenerateCodeCommand;

class SchemaGenServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            GenerateCodeCommand::class,
        ]);
    }

    public function boot()
    {
        // Any additional boot logic
    }
}
