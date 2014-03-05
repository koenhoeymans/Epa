<?php

namespace Epa\EndToEndTests\Support;

use Epa\Api\Observable;
use Epa\Api\ObserverStore;

class Login implements Observable
{
	use ObserverStore;

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