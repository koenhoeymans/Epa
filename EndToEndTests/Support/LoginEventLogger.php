<?php

/**
 * @package Epa
 */
namespace Epa\EndToEndTests\Support;

use Epa\EventMapper;
use Epa\Plugin;

/**
 * @package Epa
 */
class LoginEventLogger implements Plugin
{
	private $name = 'LoginEvent';

	private $pass = 'NotCalled';

	public function register(EventMapper $mapper)
	{
		$mapper->registerForEvent('LoginEvent', function(LoginEvent $event) {
			$this->handleLogin($event);
		});
	}

	private function handleLogin(LoginEvent $event)
	{
		$this->name = $event->getName();
		$this->pass = $event->getPass();
	}

	public function getLastLogin()
	{
		return 'last login was ' . $this->name . ':' . $this->pass;
	}
}