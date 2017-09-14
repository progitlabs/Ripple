<?php

namespace GitLab\Ripple\Providers;

use GitLab\Ripple\Support\Blade\RippleBlade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class RippleServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        #Load routes from "routes/web.php"...
        $this->loadRoutesFrom(realpath(__DIR__ . '/../../routes/web.php'));

        #Load Package Views...
        $this->loadViewsFrom(realpath(__DIR__ . '/../../resources/views'), 'Ripple');

        #Load Ripple Publishes
        $this->loadPublishableResources();

        #Load Ripple Blade Directives
        $this->loadBladeDirectives(new RippleBlade());

        #Load Ripple Helpers
        $this->loadHelpers();

        #Register Doctorine Custom Datatypes
        $this->registerCustomDataTypes();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        #Register Ripple commands
        $this->loadCommands();

        #Register Ripple Facades to app
        $this->bindFacades();

        #Load All Aliases to app
        $this->loadAlias();
    }

    /**
     * Register all aliases from configuration.
     */
    public function loadAlias()
    {
        $loadAlias = AliasLoader::getInstance();
        if (!is_null(config('ripple.aliases'))):
            foreach (config('ripple.aliases') as $abstract => $class):
                $loadAlias->alias($abstract, $class);
            endforeach;
        endif;
    }

    public function bindFacades()
    {
        if (!is_null(config('ripple.facades'))):
            foreach (config('ripple.facades') as $facade => $class):
                $this->app->bind($facade, $class);
            endforeach;
        endif;
    }

    public function loadCommands($commands = array())
    {
        #Load All Commands
        foreach (glob(__DIR__ . '/../Commands/*.php') as $command):
            $commands[] = '\GitLab\Ripple\Commands\\' . basename($command, '.php');
        endforeach;
        #Register All Commands
        $this->commands($commands);
    }

    public function loadPublishableResources()
    {
        $publishes = [
            #Publishable Assets
            'assets' => [realpath(__DIR__ . '/../../public') => public_path('vendor/gitlab/ripple/public/')],
            #Publishable Configuration
            'config' => [realpath(__DIR__ . '/../../config') => config_path('/')],
            #Publishable Database
            'database' => [realpath(__DIR__ . '/../../database/migrations') => database_path('/migrations')],
            #Publishable CSS
            'css' => [realpath(__DIR__ . '/../../public/css') => public_path('vendor/gitlab/ripple/public/css/')],
            #Publishable JS
            'js' => [realpath(__DIR__ . '/../../public/js') => public_path('vendor/gitlab/ripple/public/js/')],
        ];
        foreach ($publishes as $tag => $paths):
            $this->publishes($paths, $tag);
        endforeach;
    }

    public function loadBladeDirectives($RippleBlade)
    {
        foreach ((new \ReflectionClass(RippleBlade::class))->getMethods() as $BladeMethod)
        {
            $RippleBlade->{$BladeMethod->name}();
        }
    }

    public function loadHelpers()
    {
        foreach (glob(__DIR__ . '/../Support/Helpers/*.php') as $file)
        {
            require_once realpath($file);
        }
    }

    public function registerCustomDataTypes()
    {
        foreach (\GitLab\Ripple\Support\Database\DataTypes\Type::$register as $datatype => $class):
            \Doctrine\DBAL\Types\Type::addType($datatype, $class);
        endforeach;
    }

}
