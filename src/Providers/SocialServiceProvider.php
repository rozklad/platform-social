<?php namespace Sanatorium\Social\Providers;

use Cartalyst\Support\ServiceProvider;

class SocialServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{
		// Register all the default hooks
        $this->registerHooks();

        $this->prepareResources();
	}

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{
	}

	/**
     * Register all hooks.
     *
     * @return void
     */
    protected function registerHooks()
    {
        $hooks = [
            'product.detail.bottom' => 'sanatorium/social::hooks.share',
            'mail.footer'           => 'sanatorium/social::hooks.mail',
        ];

        $manager = $this->app['sanatorium.hooks.manager'];

        foreach ($hooks as $position => $hook) {
            $manager->registerHook($position, $hook);
        }
    }

    /**
     * Prepare the package resources.
     *
     * @return void
     */
    protected function prepareResources()
    {
        $config = realpath(__DIR__.'/../../config/config.php');

        $this->mergeConfigFrom($config, 'sanatorium-social');

        $this->publishes([
            $config => config_path('sanatorium-social.php'),
        ], 'config');
    }


}
