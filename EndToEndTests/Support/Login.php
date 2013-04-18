<?php

/**
 * @package Epa
 */
namespace Epa\EndToEndTests\Support;

use Epa\Observable;
use Epa\Pluggable;

/**
 * @package Epa
 */
class Login implements Observable
{
	use Pluggable;

	private $username = 'bar';

	private $pass = 'baz';

	public function login($name, $pass)
	{
		/**
		 * do stuff
		 */

		$success = $this->username === $name && $this->pass === $pass;
		$this->notify(new \Epa\EndToEndTests\Support\LoginEvent($name, $pass, $success));
	}
}