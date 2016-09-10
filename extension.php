<?php

use Illuminate\Foundation\Application;
use Cartalyst\Extensions\ExtensionInterface;
use Cartalyst\Settings\Repository as Settings;
use Cartalyst\Permissions\Container as Permissions;

return [

	/*
	|--------------------------------------------------------------------------
	| Name
	|--------------------------------------------------------------------------
	|
	| This is your extension name and it is only required for
	| presentational purposes.
	|
	*/

	'name' => 'Social',

	/*
	|--------------------------------------------------------------------------
	| Slug
	|--------------------------------------------------------------------------
	|
	| This is your extension unique identifier and should not be changed as
	| it will be recognized as a new extension.
	|
	| Ideally, this should match the folder structure within the extensions
	| folder, but this is completely optional.
	|
	*/

	'slug' => 'sanatorium/social',

	/*
	|--------------------------------------------------------------------------
	| Author
	|--------------------------------------------------------------------------
	|
	| Because everybody deserves credit for their work, right?
	|
	*/

	'author' => 'Sanatorium',

	/*
	|--------------------------------------------------------------------------
	| Description
	|--------------------------------------------------------------------------
	|
	| One or two sentences describing the extension for users to view when
	| they are installing the extension.
	|
	*/

	'description' => 'Social features',

	/*
	|--------------------------------------------------------------------------
	| Version
	|--------------------------------------------------------------------------
	|
	| Version should be a string that can be used with version_compare().
	| This is how the extensions versions are compared.
	|
	*/

	'version' => '3.0.3',

	/*
	|--------------------------------------------------------------------------
	| Requirements
	|--------------------------------------------------------------------------
	|
	| List here all the extensions that this extension requires to work.
	| This is used in conjunction with composer, so you should put the
	| same extension dependencies on your main composer.json require
	| key, so that they get resolved using composer, however you
	| can use without composer, at which point you'll have to
	| ensure that the required extensions are available.
	|
	*/

	'require' => [
		'sanatorium/hooks',
	],

	/*
	|--------------------------------------------------------------------------
	| Autoload Logic
	|--------------------------------------------------------------------------
	|
	| You can define here your extension autoloading logic, it may either
	| be 'composer', 'platform' or a 'Closure'.
	|
	| If composer is defined, your composer.json file specifies the autoloading
	| logic.
	|
	| If platform is defined, your extension receives convetion autoloading
	| based on the Platform standards.
	|
	| If a Closure is defined, it should take two parameters as defined
	| bellow:
	|
	|	object \Composer\Autoload\ClassLoader      $loader
	|	object \Illuminate\Foundation\Application  $app
	|
	| Supported: "composer", "platform", "Closure"
	|
	*/

	'autoload' => 'composer',

	/*
	|--------------------------------------------------------------------------
	| Service Providers
	|--------------------------------------------------------------------------
	|
	| Define your extension service providers here. They will be dynamically
	| registered without having to include them in app/config/app.php.
	|
	*/

	'providers' => [

		'Sanatorium\Social\Providers\SocialServiceProvider'

	],

	/*
	|--------------------------------------------------------------------------
	| Routes
	|--------------------------------------------------------------------------
	|
	| Closure that is called when the extension is started. You can register
	| any custom routing logic here.
	|
	| The closure parameters are:
	|
	|	object \Cartalyst\Extensions\ExtensionInterface  $extension
	|	object \Illuminate\Foundation\Application        $app
	|
	*/

	'routes' => function(ExtensionInterface $extension, Application $app)
	{

	},

	/*
	|--------------------------------------------------------------------------
	| Database Seeds
	|--------------------------------------------------------------------------
	|
	| Platform provides a very simple way to seed your database with test
	| data using seed classes. All seed classes should be stored on the
	| `database/seeds` directory within your extension folder.
	|
	| The order you register your seed classes on the array below
	| matters, as they will be ran in the exact same order.
	|
	| The seeds array should follow the following structure:
	|
	|	Vendor\Namespace\Database\Seeds\FooSeeder
	|	Vendor\Namespace\Database\Seeds\BarSeeder
	|
	*/

	'seeds' => [

	],

	/*
	|--------------------------------------------------------------------------
	| Permissions
	|--------------------------------------------------------------------------
	|
	| Register here all the permissions that this extension has. These will
	| be shown in the user management area to build a graphical interface
	| where permissions can be selected to allow or deny user access.
	|
	| For detailed instructions on how to register the permissions, please
	| refer to the following url https://cartalyst.com/manual/permissions
	|
	*/

	'permissions' => function(Permissions $permissions)
	{

	},

	/*
	|--------------------------------------------------------------------------
	| Widgets
	|--------------------------------------------------------------------------
	|
	| Closure that is called when the extension is started. You can register
	| all your custom widgets here. Of course, Platform will guess the
	| widget class for you, this is just for custom widgets or if you
	| do not wish to make a new class for a very small widget.
	|
	*/

	'widgets' => function()
	{

	},

	/*
	|--------------------------------------------------------------------------
	| Settings
	|--------------------------------------------------------------------------
	|
	| Register any settings for your extension. You can also configure
	| the namespace and group that a setting belongs to.
	|
	*/

	'settings' => function(Settings $settings, Application $app)
	{
		$settings->find('platform')->section('social', function ($s) {
			$s->name = trans('sanatorium/social::settings.title');

            $s->fieldset('social', function ($f) {
                $f->name = trans('sanatorium/social::common.title');

                $f->field('show_shared_counts', function ($f) {
                    $f->name   = trans('sanatorium/social::settings.shared_counts');;
                    $f->type   = 'radio';
                    $f->config = 'sanatorium-social.show_shared_counts';

                    $f->option('yes', function ($o) {
                        $o->value = true;
                        $o->label = trans('common.yes');
                    });

                    $f->option('no', function ($o) {
                        $o->value = false;
                        $o->label = trans('common.no');
                    });

                });

                $shareable = config('sanatorium-social.shareable');

                foreach( $shareable as $share => $active ) {

	                $f->field($share, function ($f) use ($share) {
	                    $f->name   = ucfirst($share);
	                    $f->type   = 'radio';
	                    $f->config = 'sanatorium-social.shareable.' . $share;

	                    $f->option('yes', function ($o) {
	                        $o->value = true;
	                        $o->label = trans('common.yes');
	                    });

	                    $f->option('no', function ($o) {
	                        $o->value = false;
	                        $o->label = trans('common.no');
	                    });

	                });

            	}

            });
        });

		$settings->find('platform')->section('social', function ($s) {
			$s->name = trans('sanatorium/social::settings.title');

			$s->fieldset('links', function ($f) {
				$f->name = trans('sanatorium/social::settings.links.title');

				$linkable = config('sanatorium-social.links');

            	foreach( $linkable as $site => $link ) {

					$f->field($site.'_link', function ($f) use ($site) {
	                    $f->name   = trans('sanatorium/social::settings.'.$site.'.link');
	                    $f->info   = trans('sanatorium/social::settings.'.$site.'.link');
	                    $f->type   = 'input';
	                    $f->config = 'sanatorium-social.links.' . $site;
	                });
				}

			});

            $s->fieldset('facebook', function ($f) {
                $f->name = trans('sanatorium/social::settings.facebook.title');

                $f->field('facebook_enabled', function ($f) {
                	$f->name   = trans('sanatorium/social::settings.facebook.enabled');
                	$f->type   = 'radio';
                	$f->config = 'sanatorium-social.connections.facebook';

                	$f->option('yes', function ($o) {
                		$o->value = true;
                		$o->label = trans('common.yes');
                	});

                	$f->option('no', function ($o) {
                		$o->value = false;
                		$o->label = trans('common.no');
                	});
                });

                $f->field('facebook_identifier', function ($f) {
                    $f->name   = trans('sanatorium/social::settings.facebook.identifier');
                    $f->info   = trans('sanatorium/social::settings.facebook.identifier');
                    $f->type   = 'input';
                    $f->config = 'cartalyst.sentinel-addons.social.connections.facebook.identifier';
                });

                $f->field('facebook_secret', function ($f) {
                    $f->name   = trans('sanatorium/social::settings.facebook.secret');
                    $f->info   = trans('sanatorium/social::settings.facebook.secret');
                    $f->type   = 'input';
                    $f->config = 'cartalyst.sentinel-addons.social.connections.facebook.secret';
                });
            });

			$s->fieldset('github', function ($f) {
                $f->name = trans('sanatorium/social::settings.github.title');

                $f->field('github_enabled', function ($f) {
                	$f->name   = trans('sanatorium/social::settings.github.enabled');
                	$f->type   = 'radio';
                	$f->config = 'sanatorium-social.connections.github';

                	$f->option('yes', function ($o) {
                		$o->value = true;
                		$o->label = trans('common.yes');
                	});

                	$f->option('no', function ($o) {
                		$o->value = false;
                		$o->label = trans('common.no');
                	});
                });

                $f->field('github_identifier', function ($f) {
                    $f->name   = trans('sanatorium/social::settings.github.identifier');
                    $f->info   = trans('sanatorium/social::settings.github.identifier');
                    $f->type   = 'input';
                    $f->config = 'cartalyst.sentinel-addons.social.connections.github.identifier';
                });

                $f->field('github_secret', function ($f) {
                    $f->name   = trans('sanatorium/social::settings.github.secret');
                    $f->info   = trans('sanatorium/social::settings.github.secret');
                    $f->type   = 'input';
                    $f->config = 'cartalyst.sentinel-addons.social.connections.github.secret';
                });
            });

            $s->fieldset('google', function ($f) {
                $f->name = trans('sanatorium/social::settings.google.title');

                $f->field('google_enabled', function ($f) {
                	$f->name   = trans('sanatorium/social::settings.google.enabled');
                	$f->type   = 'radio';
                	$f->config = 'sanatorium-social.connections.google';

                	$f->option('yes', function ($o) {
                		$o->value = true;
                		$o->label = trans('common.yes');
                	});

                	$f->option('no', function ($o) {
                		$o->value = false;
                		$o->label = trans('common.no');
                	});
                });

                $f->field('google_identifier', function ($f) {
                    $f->name   = trans('sanatorium/social::settings.google.identifier');
                    $f->info   = trans('sanatorium/social::settings.google.identifier');
                    $f->type   = 'input';
                    $f->config = 'cartalyst.sentinel-addons.social.connections.google.identifier';
                });

                $f->field('google_secret', function ($f) {
                    $f->name   = trans('sanatorium/social::settings.google.secret');
                    $f->info   = trans('sanatorium/social::settings.google.secret');
                    $f->type   = 'input';
                    $f->config = 'cartalyst.sentinel-addons.social.connections.google.secret';
                });
            });

            $s->fieldset('instagram', function ($f) {
                $f->name = trans('sanatorium/social::settings.instagram.title');

                $f->field('instagram_enabled', function ($f) {
                	$f->name   = trans('sanatorium/social::settings.instagram.enabled');
                	$f->type   = 'radio';
                	$f->config = 'sanatorium-social.connections.instagram';

                	$f->option('yes', function ($o) {
                		$o->value = true;
                		$o->label = trans('common.yes');
                	});

                	$f->option('no', function ($o) {
                		$o->value = false;
                		$o->label = trans('common.no');
                	});
                });

                $f->field('instagram_identifier', function ($f) {
                    $f->name   = trans('sanatorium/social::settings.instagram.identifier');
                    $f->info   = trans('sanatorium/social::settings.instagram.identifier');
                    $f->type   = 'input';
                    $f->config = 'cartalyst.sentinel-addons.social.connections.instagram.identifier';
                });

                $f->field('instagram_secret', function ($f) {
                    $f->name   = trans('sanatorium/social::settings.instagram.secret');
                    $f->info   = trans('sanatorium/social::settings.instagram.secret');
                    $f->type   = 'input';
                    $f->config = 'cartalyst.sentinel-addons.social.connections.instagram.secret';
                });
            });

			$s->fieldset('linkedin', function ($f) {
                $f->name = trans('sanatorium/social::settings.linkedin.title');

                $f->field('linkedin_enabled', function ($f) {
                	$f->name   = trans('sanatorium/social::settings.linkedin.enabled');
                	$f->type   = 'radio';
                	$f->config = 'sanatorium-social.connections.linkedin';

                	$f->option('yes', function ($o) {
                		$o->value = true;
                		$o->label = trans('common.yes');
                	});

                	$f->option('no', function ($o) {
                		$o->value = false;
                		$o->label = trans('common.no');
                	});
                });

                $f->field('linkedin_identifier', function ($f) {
                    $f->name   = trans('sanatorium/social::settings.linkedin.identifier');
                    $f->info   = trans('sanatorium/social::settings.linkedin.identifier');
                    $f->type   = 'input';
                    $f->config = 'cartalyst.sentinel-addons.social.connections.linkedin.identifier';
                });

                $f->field('linkedin_secret', function ($f) {
                    $f->name   = trans('sanatorium/social::settings.linkedin.secret');
                    $f->info   = trans('sanatorium/social::settings.linkedin.secret');
                    $f->type   = 'input';
                    $f->config = 'cartalyst.sentinel-addons.social.connections.linkedin.secret';
                });
            });

			$s->fieldset('microsoft', function ($f) {
                $f->name = trans('sanatorium/social::settings.microsoft.title');

                $f->field('microsoft_enabled', function ($f) {
                	$f->name   = trans('sanatorium/social::settings.microsoft.enabled');
                	$f->type   = 'radio';
                	$f->config = 'sanatorium-social.connections.microsoft';

                	$f->option('yes', function ($o) {
                		$o->value = true;
                		$o->label = trans('common.yes');
                	});

                	$f->option('no', function ($o) {
                		$o->value = false;
                		$o->label = trans('common.no');
                	});
                });

                $f->field('microsoft_identifier', function ($f) {
                    $f->name   = trans('sanatorium/social::settings.microsoft.identifier');
                    $f->info   = trans('sanatorium/social::settings.microsoft.identifier');
                    $f->type   = 'input';
                    $f->config = 'cartalyst.sentinel-addons.social.connections.microsoft.identifier';
                });

                $f->field('microsoft_secret', function ($f) {
                    $f->name   = trans('sanatorium/social::settings.microsoft.secret');
                    $f->info   = trans('sanatorium/social::settings.microsoft.secret');
                    $f->type   = 'input';
                    $f->config = 'cartalyst.sentinel-addons.social.connections.microsoft.secret';
                });
            });

			$s->fieldset('twitter', function ($f) {
                $f->name = trans('sanatorium/social::settings.twitter.title');

                $f->field('twitter_enabled', function ($f) {
                	$f->name   = trans('sanatorium/social::settings.twitter.enabled');
                	$f->type   = 'radio';
                	$f->config = 'sanatorium-social.connections.twitter';

                	$f->option('yes', function ($o) {
                		$o->value = true;
                		$o->label = trans('common.yes');
                	});

                	$f->option('no', function ($o) {
                		$o->value = false;
                		$o->label = trans('common.no');
                	});
                });

                $f->field('twitter_identifier', function ($f) {
                    $f->name   = trans('sanatorium/social::settings.twitter.identifier');
                    $f->info   = trans('sanatorium/social::settings.twitter.identifier');
                    $f->type   = 'input';
                    $f->config = 'cartalyst.sentinel-addons.social.connections.twitter.identifier';
                });

                $f->field('twitter_secret', function ($f) {
                    $f->name   = trans('sanatorium/social::settings.twitter.secret');
                    $f->info   = trans('sanatorium/social::settings.twitter.secret');
                    $f->type   = 'input';
                    $f->config = 'cartalyst.sentinel-addons.social.connections.twitter.secret';
                });
            });

			$s->fieldset('tumblr', function ($f) {
                $f->name = trans('sanatorium/social::settings.tumblr.title');

                $f->field('tumblr_enabled', function ($f) {
                	$f->name   = trans('sanatorium/social::settings.tumblr.enabled');
                	$f->type   = 'radio';
                	$f->config = 'sanatorium-social.connections.tumblr';

                	$f->option('yes', function ($o) {
                		$o->value = true;
                		$o->label = trans('common.yes');
                	});

                	$f->option('no', function ($o) {
                		$o->value = false;
                		$o->label = trans('common.no');
                	});
                });

                $f->field('tumblr_identifier', function ($f) {
                    $f->name   = trans('sanatorium/social::settings.tumblr.identifier');
                    $f->info   = trans('sanatorium/social::settings.tumblr.identifier');
                    $f->type   = 'input';
                    $f->config = 'cartalyst.sentinel-addons.social.connections.tumblr.identifier';
                });

                $f->field('tumblr_secret', function ($f) {
                    $f->name   = trans('sanatorium/social::settings.tumblr.secret');
                    $f->info   = trans('sanatorium/social::settings.tumblr.secret');
                    $f->type   = 'input';
                    $f->config = 'cartalyst.sentinel-addons.social.connections.tumblr.secret';
                });
            });

            $s->fieldset('vkontakte', function ($f) {
                $f->name = trans('sanatorium/social::settings.vkontakte.title');

                $f->field('vkontakte_enabled', function ($f) {
                	$f->name   = trans('sanatorium/social::settings.vkontakte.enabled');
                	$f->type   = 'radio';
                	$f->config = 'sanatorium-social.connections.vkontakte';

                	$f->option('yes', function ($o) {
                		$o->value = true;
                		$o->label = trans('common.yes');
                	});

                	$f->option('no', function ($o) {
                		$o->value = false;
                		$o->label = trans('common.no');
                	});
                });

                $f->field('vkontakte_identifier', function ($f) {
                    $f->name   = trans('sanatorium/social::settings.vkontakte.identifier');
                    $f->info   = trans('sanatorium/social::settings.vkontakte.identifier');
                    $f->type   = 'input';
                    $f->config = 'cartalyst.sentinel-addons.social.connections.vkontakte.identifier';
                });

                $f->field('vkontakte_secret', function ($f) {
                    $f->name   = trans('sanatorium/social::settings.vkontakte.secret');
                    $f->info   = trans('sanatorium/social::settings.vkontakte.secret');
                    $f->type   = 'input';
                    $f->config = 'cartalyst.sentinel-addons.social.connections.vkontakte.secret';
                });
            });
        });
	},

	/*
	|--------------------------------------------------------------------------
	| Menus
	|--------------------------------------------------------------------------
	|
	| You may specify the default various menu hierarchy for your extension.
	| You can provide a recursive array of menu children and their children.
	| These will be created upon installation, synchronized upon upgrading
	| and removed upon uninstallation.
	|
	| Menu children are automatically put at the end of the menu for extensions
	| installed through the Operations extension.
	|
	| The default order (for extensions installed initially) can be
	| found by editing app/config/platform.php.
	|
	*/

	'menus' => [

		'admin' => [

			/*[
				'slug'  => 'admin-sanatorium-social',
				'name'  => 'Social',
				'class' => 'fa fa-circle-o',
				'uri'   => 'social',
				'regex' => '/:admin\/social/i',
			],*/

		],

		'main' => [

		],

	],

];
