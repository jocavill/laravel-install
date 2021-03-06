<?php namespace Paddons\Install;

use \Illuminate\Support\ServiceProvider;
use Paddons\Install\Commands\InstallCommand;

class InstallServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['install'] = $this->app->share(function($app)
        {
            return new InstallCommand();
        });

        $this->commands('install');
    }
}