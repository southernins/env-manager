<?php
/**
 *
 */

namespace SouthernIns\EnvManager;

use Illuminate\Support\ServiceProvider;
use SouthernIns\EnvManager\Commands\CheckCommand;
use SouthernIns\EnvManager\Commands\PushCommand;
use SouthernIns\EnvManager\Commands\PullCommand;


class EnvManagerServiceProvider extends ServiceProvider {

    public function boot(){

        // Boot runs after ALL providers are registered
        $this->publishes([
            __DIR__.'/config/env-manager.php' => config_path('env-manager.php'),
//            __DIR__.'/githooks/pre-commit' =>  base_path() .  '/.git/hooks/pre-commit',
        ]);

    } //- END function boot()

    public function register(){

        if( $this->app->runningInConsole() ){
            $this->commands([
                CheckCommand::class,
                PushCommand::class,
                PullCommand::class,
            ]);
        }

    } //- END function register()

    // Pre-commit change #1

} // - END class BuildServiceProvider{}
