<?php namespace Ademes\Core;

use Illuminate\Support\ServiceProvider;
use Ademes\Core\Auth\AuthClient as AuthClient;
use Ademes\Core\User\UserClient as UserClient;

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
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
