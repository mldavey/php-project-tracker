<?php

namespace Core;

/**
* View
*
* PHP version 7.1
*/

class View {
	/**
	* Render the view
	*
	* @param string $view  The file for the view
	*
	* @return void
	*/

	public static function render($view, $args = []) {

		extract($args, EXTR_SKIP);
		
		$file = "../App/Views/$view"; // relative to Core directory

		if(is_readable($file)) {
			require $file;
		} else {
			echo "Could not find $file";
		}
	}
}