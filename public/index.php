<?php

/**
* Front Controller
*
* PHP version 7.1.10
*/

/**
* Autoloader
**/
spl_autoload_register(function ($class) {
	$root = dirname(__DIR__);
	$file = $root  . '/' . str_replace('\\', '/', $class) . '.php';
	if(is_readable($file)) {
		require $root  . '/' . str_replace('\\', '/', $class) . '.php';
	}
});

/**
* Routing
*/

$router = new Core\Router();

//Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

$router->dispatch($_SERVER['QUERY_STRING']);