<?php

namespace App\Controllers\Admin;

/**
* User Admin Controller
*
* PHP version 7.1.10
*/
class Users extends \Core\Controller {
	/**
	* Show the index page
	*
	* @return void
	*/
	public function indexAction() {
		echo 'User index action';
	}

	/**
	* Before filter - Call before an action method
	*
	* @return void
	*/
	protected function before() {
		echo "(before) ";
	}

	/**
	* After filter - Call after an action method
	*
	* @return void
	*/
	protected function after() {
		echo " (after)";
	}
}