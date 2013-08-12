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
class LoginNameChanger implements Plugin
{
	public function register(EventMapper $mapper)
	{
		$mapper
			->registerForEvent('LoginEvent', function(LoginEvent $event)
				{
					$this->handleLogin($event);
				})
			->first();
	}

	private function handleLogin(LoginEvent $event)
	{
		$event->setName('baz');
	}
}