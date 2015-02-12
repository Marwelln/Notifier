<?php namespace Marwelln\Notifier;

use Illuminate\Support\ServiceProvider;
use Session;

class NotifierServiceProvider extends ServiceProvider {
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {
		$this->app->bind('Marwelln\Notifier\SessionStore');
	}

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot() {
		$this->loadViewsFrom(__DIR__ . '/../../assets/views', 'notify');

		$this->publishes([
			__DIR__ . '/../../config' => base_path('config')
		], 'config');

		$this->publishes([
			__DIR__ . '/../../assets/less' => base_path('resources/assets/vendor/marwelln/notifier')
		], 'less');

		// Send notifier variable to given views.
		view()->composer(config('marwelln.notifier.notifierViews', ['layout.default']), function($view) {
			$view->with('notifier', new Notify(Session::get('notifier', [])));
		});
	}
}