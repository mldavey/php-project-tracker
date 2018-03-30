<?php

namespace Core;

/**
* Base Controller
*
* PHP version 7.1.10
*/

abstract class Controller {
	/** 
	* Parameters from the matched route
	* @var array
	*/
	protected $route_params = [];

	/**
	* Class constructor
	*
	* @param array $route_params   Parameters from the route
	*
	* @return void
	*/
	public function __construct($route_params) {
		$this->route_params = $route_params;
	}

	/**
	* Trigger the __call() magic method to prepend or append code that must
	* be run along with each funcion. __call() is run when a method does not
	* exist or is inaccessible. Action methods should be named with "Action"
	* at the end.
	*
	* @param string $name  The method name
	* @param string $args  Arguments passed to the method
	*
	* @return void
	*/
	public function __call($name, $args) {
		$method = $name . 'Action';

		if(method_exists($this, $method)) {
			if($this->before() !== false) {
				call_user_func_array([$this, $method], $args);
				$this->after();
			} else {
				echo "Method $method not found in controller " . get_class($this);
			}
		}
	}

	/**
	* Before - Call before an action method
	*
	* @return void
	*/
	protected function before() {

	}

	/**
	* After - Call after an action method
	*
	* @return void
	*/
	protected function after() {
		
	}

}