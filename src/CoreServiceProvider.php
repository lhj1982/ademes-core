<?php namespace Ademes\Core;

use Illuminate\Support\ServiceProvider;
use Ademes\Core\Auth\AuthClient as AuthClient;
use Ademes\Core\User\UserClient as UserClient;
use Ademes\Core\Http\Client as Client;
use Ademes\Core\Solr\SolariumClientImpl as SolariumClientImpl;

class CoreServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('ademes/core');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['authClient'] = $this->app->share(function($app)
        {
            return new AuthClient;
        });

        $this->app['userClient'] = $this->app->share(function($app)
        {
            return new UserClient;
        });

        $this->app['client'] = $this->app->share(function($app)
        {
            return new Client;
        });

        $this->app['solariumClient'] = $this->app->share(function($app)
        {
            return new SolariumClientImpl();
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('AuthClient', 'Ademes\Core\Facades\AuthClient');
            $loader->alias('UserClient', 'Ademes\Core\Facades\UserClient');
            $loader->alias('HttpClient', 'Ademes\Core\Facades\HttpClient');
            $loader->alias('SolariumClient', 'Ademes\Core\Facades\SolariumClient');
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

}
