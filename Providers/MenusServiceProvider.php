<?php
namespace App\Modules\Menus\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class MenusServiceProvider extends ServiceProvider
{
	/**
	 * Register the Menus module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\Menus\Providers\RouteServiceProvider');

		//Bind GalleryRepository Facade to the IoC Container
		App::bind('MenuRepository', function()
		{
			return new App\Modules\Menus\Repositories\MenuRepository;
		});
		$this->registerNamespaces();
	}

	/**
	 * Register the Menus module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('menus', realpath(__DIR__.'/../Resources/Lang'));

		View::addNamespace('menus', realpath(__DIR__.'/../Resources/Views'));
	}
}
