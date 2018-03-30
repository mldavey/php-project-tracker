<?php

namespace App\Controllers;

use \Core\View;

/**
* Entries Controller
*
* PHP version 7.1.10
*/

class Home extends \Core\Controller {
	/**
	* Show the index page
	*
	* @return void
	*/
	public function indexAction() {
		View::render('Home/index.php', [
			'name' => 'Maureen',
			'colors' => ['red', 'orange', 'yellow']
		]);
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