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
     * Boot the service provider
     *
     * @return void
     */
    public function boot()
    {
        $this->commands('kowali.commands.contents-migrate');
        $this->commands('kowali.commands.contents-taxonomies');
    }

    /**
     *
     * @return void
     */
    public function register (){

        $this->app->bindShared('kowali.commands.contents-migrate', function($app){
            return new Commands\ContentsMigrateCommand;
        });
        $this->app->bindShared('kowali.commands.contents-taxonomies', function($app){
            return new Commands\ContentsTaxonomiesCommand;
        });

        $this->app->bindShared('kowali.filter', function($app){
            return new Filtering\FilterRepository;
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




