<?php

namespace Core;

/**
* Router
*
* PHP version 7.1.10
*/

class Router {
	
	/**
	* Routing Table
	* @var array
	*/
	protected $routes = [];

	/**
	* Parameters from the matched route
	* @var array
	*/
	protected $params = [];

	/**
	* Add a route to the routing table
	*
	* @param string $route The route URL
	* @param array $params Parameters (controller, action, etc.)
	*
	* @return void
	*/
	public function add($route, $params = []) {
		//Convert route to regex, escape forward slashes
		$route = preg_replace('/\//', '\\/', $route);

		//Convert to format {controller}
		$route = preg_replace('/\{([a-z]+)\}/',  '(?P<\1>[a-z-]+)', $route);

		//Convert variables with custom regular expressions ex. id number
		$route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

		//Add start/end delimiters and make case insensitive
		$route = '/^' . $route . '$/i';

		$this->routes[$route] = $params;
	}

	/**
	* Get all the routes from the routing table
	*
	* @return array
	*/
	public function getRoutes() {
		return $this->routes;
	}

	/** 
	* Match the route to routes in the routing table, setting the $params
	* property if a route is found.
	*
	* @param string $url The route URL
	*
	* @return boolean true if a match found, otherwise false
	*/

	public function match($url) {
		foreach($this->routes as $route => $params) {
			if(preg_match($route, $url, $matches)) {

				foreach($matches as $key => $match) {
					if(is_string($key)) {
						$params[$key] = $match;
					}
				}

				$this->params = $params;
				return true;
			}
		}

		return false;
	}

	/** 
	* Get the currently matched parameters
	*
	* @return array
	*/

	public function getParams() {
		return $this->params;
	}

	/**
	* Dispatch the route, creating the controller object and running the action method
	*
	* @param string $url The route URL
	* 
	* @return void
	*/
	public function dispatch($url) {

		$url = $this->removeQueryStringVariables($url);

		if($this->match($url)) {
			$controller = $this->params['controller'];
			$controller = $this->convertToStudlyCaps($controller);
			// $controller = "App\Controllers\\$controller";
			$controller = $this->getNamespace() . $controller;

			if(class_exists($controller)) {
				$controller_object = new $controller($this->params);

				$action = $this->params['action'];
				$action = $this->convertToCamelCase($action);

				if(preg_match('/action$/i', $action) == 0) {
					$controller_object->$action();
				} else {
					throw new \Exception("Method $action in controller $controller cannot be called directly. Remove the 'Action' suffix to call this method.");
				}
			} else {
				echo 'Controller class ' . $controller . ' not found';
			}
		} else {
			echo 'No route matched.';
		}
	}

	/**
	* Convert the string with hyphens to StudlyCaps,
	* e.g. filter-entries => FilterEntries
	*
	* @param string $string The string to convert
	*
	* @return string
	*/
	protected function convertToStudlyCaps($string) {
		return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
	}

	/**
	* Convert the string with hyphens to camelCase,
	* e.g. delete-entry => deleteEntry
	* 
	* @param string $string The string to convert
	*
	* @return string
	*/
	protected function convertToCamelCase($string) {
		return lcfirst($this->convertToStudlyCaps($string));
	}

	/**
	* Remove query string variables so the router can match the URL
	*
	* @param string $url   The full URL
	*
	* @return string    The URL with the variables removed
	*/
	protected function removeQueryStringVariables($url) {
		if($url != '') {
			$explode = explode('&', $url, 2);

			if(strpos($explode[0], '=') === FALSE) {
				$url = $explode[0];
			} else {
				$url = '';
			}
		}

		return $url;
	}

	/**
	* Get the namespace for the Controller class. The namespace defined in the route parameters is added if found.
	*
	* @return string  The request URL
	*/
	protected function getNamespace() {
		
		$namespace = 'App\Controllers\\';

		if(array_key_exists('namespace', $this->params)) {
			$namespace .= $this->params['namespace'] . '\\';
		}

		return $namespace;
	}
}