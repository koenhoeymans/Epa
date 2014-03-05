<?php

namespace Epa\EndToEndTests\Support;

use Epa\Api\EventDispatcher;
use Epa\Api\Plugin;

class SuccessLoginLogger implements Plugin
{
	private $log = '';

	public function registerHandlers(EventDispatcher $mapper)
	{
		$mapper->registerForEvent(
			'Epa\\EndToEndTests\\Support\\LoginEvent', $this->handleSuccessLogin()
		);
	}

	private function handleSuccessLogin()
	{
		return function(\Epa\EndToEndTests\Support\LoginEvent $event)
		{
			if (!$event->loginSucceeded())
			{
				return;
			}
			$this->log = 'success for ' . $event->getName() . ':' . $event->getPass();
		};
	}

	public function getLog()
	{
		return $this->log;
	}
}