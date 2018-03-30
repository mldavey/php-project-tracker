<?php

namespace App\Controllers;

/**
* Entries Controller
*
* PHP version 7.1.10
*/

class Entries extends \Core\Controller {
	/**
	* Show the index page
	*
	* @return void
	*/
	public function indexAction() {
		echo 'index action entries';
		echo '<p>Query string parameters: <pre>' .
             htmlspecialchars(print_r($_GET, true)) . '</pre></p>';
	}

	/**
	* Show the add new page
	*
	* @return void
	*/
	public function addAction() {
		echo 'Hello add';
	}

	/**
	* Show the edit page
	*
	* @return void
	*/
	public function editAction() {
		echo 'Hello edit';
		echo '<p>Route parameters: <pre>' .
             htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
	}
}