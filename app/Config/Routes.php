<?php namespace Config;

/**
 * --------------------------------------------------------------------
 * URI Routing
 * --------------------------------------------------------------------
 * This file lets you re-map URI requests to specific controller functions.
 *
 * Typically there is a one-to-one relationship between a URL string
 * and its corresponding controller class/method. The segments in a
 * URL normally follow this pattern:
 *
 *    example.com/class/method/id
 *
 * In some instances, however, you may want to remap this relationship
 * so that a different class/function is called than the one
 * corresponding to the URL.
 */

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 * The RouteCollection object allows you to modify the way that the
 * Router works, by acting as a holder for it's configuration settings.
 * The following methods can be called on the object to modify
 * the default operations.
 *
 *    $routes->defaultNamespace()
 *
 * Modifies the namespace that is added to a controller if it doesn't
 * already have one. By default this is the global namespace (\).
 *
 *    $routes->defaultController()
 *
 * Changes the name of the class used as a controller when the route
 * points to a folder instead of a class.
 *
 *    $routes->defaultMethod()
 *
 * Assigns the method inside the controller that is ran when the
 * Router is unable to determine the appropriate method to run.
 *
 *    $routes->setAutoRoute()
 *
 * Determines whether the Router will attempt to match URIs to
 * Controllers when no specific route has been defined. If false,
 * only routes that have been defined here will be available.
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');


// auth routes
$routes->group('', ['namespace' => 'App\Controllers'], function($routes) {
    // Login/out
    $routes->get('login', 'AuthController::login', ['as' => 'login']);
    $routes->post('login', 'AuthController::attemptLogin');
    $routes->get('logout', 'AuthController::logout');

    // Registration
    $routes->get('register', 'AuthController::register', ['as' => 'register']);
    $routes->post('register', 'AuthController::attemptRegister');

    // Forgot/Resets
    $routes->get('forgot', 'AuthController::forgotPassword', ['as' => 'forgot']);
    $routes->post('forgot', 'AuthController::attemptForgot');
    $routes->get('reset-password', 'AuthController::resetPassword', ['as' => 'reset-password']);
    $routes->post('reset-password', 'AuthController::attemptReset');
});


$routes->group('', ['namespace' => 'App\Controllers\User', 'filter' => 'login'], function($routes) {
	$routes->get('challenges',			'UserController::challenges');
	$routes->get('challenges/(:num)',	'UserController::challenges/$1');
	$routes->post('challenges/(:num)',	'UserController::flagSubmit/$1');
});


$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'role:admin'], function($routes) {
    $routes->get('/', 'Admin::index');

    $routes->group('teams', function($routes)
	{
		$routes->get('/', 				'TeamController::index');
		$routes->get('new', 			'TeamController::new');
		$routes->get('(:num)/edit', 	'TeamController::edit/$1');
		$routes->get('(:num)', 			'TeamController::show/$1');
		$routes->post('/', 				'TeamController::create');
		$routes->post('(:num)/delete',	'TeamController::delete/$1');
		$routes->post('(:num)', 		'TeamController::update/$1');
		$routes->post('(:num)/authcode','TeamController::changeAuthCode/$1');
    });
    
    $routes->group('users', function($routes)
	{
		$routes->get('/', 				'UserController::index');
		$routes->get('new', 			'UserController::new');
		$routes->get('(:num)/edit', 	'UserController::edit/$1');
		$routes->get('(:num)', 			'UserController::show/$1');
		$routes->post('/', 				'UserController::create');
		$routes->post('(:num)/delete',	'UserController::delete/$1');
		$routes->post('(:num)', 		'UserController::update/$1');
	});

	$routes->group('categories', function($routes)
	{
		$routes->get('/', 				'CategoryController::index');
		$routes->get('new', 			'CategoryController::new');
		$routes->get('(:num)/edit', 	'CategoryController::edit/$1');
		$routes->get('(:num)', 			'CategoryController::show/$1');
		$routes->post('/', 				'CategoryController::create');
		$routes->post('(:num)/delete',	'CategoryController::delete/$1');
		$routes->post('(:num)', 		'CategoryController::update/$1');
	});

	$routes->group('challenges', function($routes)
	{
		$routes->get('/', 				'ChallengeController::index');
		$routes->get('new', 			'ChallengeController::new');
		$routes->get('(:num)/edit', 	'ChallengeController::edit/$1');
		$routes->get('(:num)', 			'ChallengeController::show/$1');
		$routes->post('/', 				'ChallengeController::create');
		$routes->post('(:num)/delete',	'ChallengeController::delete/$1');
		$routes->post('(:num)', 		'ChallengeController::update/$1');
	});

	$routes->group('challenges/(:num)/flags', function($routes)
	{
		$routes->get('/', 				'FlagController::index$1');
		$routes->get('new', 			'FlagController::new$1');
		$routes->get('(:num)/edit', 	'FlagController::edit/$1/$2');
		$routes->get('(:num)', 			'FlagController::show/$1/$2');
		$routes->post('/', 				'FlagController::create/$1');
		$routes->post('(:num)/delete',	'FlagController::delete/$1/$2');
		$routes->post('(:num)', 		'FlagController::update/$1/$2');
	});
});

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
