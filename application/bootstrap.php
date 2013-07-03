<?php defined('SYSPATH') or die('No direct script access.');

//-- Environment setup --------------------------------------------------------

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('America/Chicago');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

//-- Configuration and initialization -----------------------------------------

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = $_SERVER['KOHANA_ENV'];
}

Kohana::$environment = ($_SERVER['SERVER_NAME'] !== 'localhost') ? Kohana::PRODUCTION : Kohana::DEVELOPMENT;

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */

Kohana::init(array(
    'base_url'   => '/',
    'index_file' => FALSE,
    'profile'    => Kohana::$environment !== Kohana::PRODUCTION,
    // 'caching'    => Kohana::$environment === Kohana::PRODUCTION,
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Kohana_Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'auth'       => MODPATH.'auth',       // Basic authentication
	// 'cache'      => MODPATH.'cache',      // Caching with multiple backends
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	'database'   => MODPATH.'database',   // Database access
	'email'      => MODPATH.'email',   // Email Sending
	'image'      => MODPATH.'image',      // Image manipulation
	'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	// 'oauth'      => MODPATH.'oauth',      // OAuth authentication
	'pagination' => MODPATH.'pagination', // Paging of results
	// 'unittest'   => MODPATH.'unittest',   // Unit testing
	'facebooko'   => MODPATH.'facebooko',   // Facebook
	'userguide'  => MODPATH.'userguide',  // User guide and API documentation
	));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */

Route::set('static_users', '<action>',
	array(
		'action' => '(logout|login|register)'
	))
	->defaults(array(
		'controller' => 'users'
	));

Route::set('manage', '<controller>/<action>/<random>',
	array(
		'action' => '(manage|manage_destroy|manage_remove_image)',
		'random' => '.*'
	))
	->defaults(array(
		'controller' => 'posts'
	));

Route::set('subcategories', '<controller>(/<uri>(/<id>))',
	array(
		'controller' => 'subcategories',
		'uri' => '(.)*'
	))
	->defaults(array(
		'action'     => 'view'
	));

Route::set('blogs', '<controller>/<uri>',
	array(
		'controller' => 'blogs',
		'uri' => '(.)+'
	))
	->defaults(array(
		'blogs'      => 'blogs',
		'action'     => 'view'
	));

Route::set('posts', '<controller>(/<uri>(/<id>))',
	array(
		'controller' => 'posts',
		'uri' => '((?!advertisements|destroy|add|search|edit|remove_image).)*'
	))
	->defaults(array(
		'action'     => 'view'
	));


Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'categories',
		'action'     => 'index',
	));

// send everything else to a 404 page
Route::set('catch_all', '<path>', array('path' => '.*'))
	->defaults(array(
		'controller' => 'errors',
		'action'     => '404',
	));

if ( ! defined('SUPPRESS_REQUEST'))
{
	/**
	 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
	 * If no source is specified, the URI will be automatically detected.
	 */
	echo Request::instance()
		->execute()
		->send_headers()
		->response;
}
