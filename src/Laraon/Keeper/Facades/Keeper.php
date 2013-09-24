<?php

/**
 * @package Laraon/Keeper
 * @author Volodimyr Terion Kornilov <mail@terion.name>
 * @copyright Copyright (c) 2013 by Laraon
 * @license MIT
 * @version 1.0
 * @access public
 */

namespace Laraon\Keeper\Facades;

use Illuminate\Support\Facades\Facade;

class Keeper extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'keeper'; }

}