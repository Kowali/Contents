<?php namespace Kowali\Contents;

use Illuminate\Support\ServiceProvider;

class ContentsServiceProvider extends ServiceProvider {

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
        $contents = $this->app['kowali.contents'];

        $contents->addTypes([
            'post'  => [
                'model' => 'Kowali\Contents\Models\Post',
                'controller' => 'Kowali\Contents\Controllers\ContentsController',
            ],
            'page'  => [
                'model' => 'Kowali\Contents\Models\Page',
                'controller' => 'Kowali\Contents\Controllers\ContentsController',
            ],
            'menu'  => [
                'model' => 'Kowali\Contents\Models\Menu',
                'controller' => 'Kowali\Contents\Controllers\ContentsController',
            ],
            'menu_item' => [
                'model' => 'Kowali\Contents\Models\MenuItem',
                'controller' => 'Kowali\Contents\Controllers\ContentsController',
            ],
            'link' => [
                'model' => 'Kowali\Contents\Models\Link',
                'controller' => 'Kowali\Contents\Controllers\ContentsController',
            ],
        ]);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bindShared('kowali.contents', function(){
            return new ContentRepository;
        });
        $this->app->bind('Kowali\Contents\ContentRepository', 'kowali.contents');

        $this->app->bindShared('kowali.filter', function($app){
            return new Filters\FilterRepository;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['kowali.contents', 'kowali.filter'];
    }
}
