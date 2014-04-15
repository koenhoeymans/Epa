<?php

namespace Epa\EndToEndTests\Support;

use Epa\Api\EventDispatcher;
use Epa\Api\Plugin;

class LoginNameChanger implements Plugin
{
	public function registerHandlers(EventDispatcher $dispatcher)
	{
		$dispatcher
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