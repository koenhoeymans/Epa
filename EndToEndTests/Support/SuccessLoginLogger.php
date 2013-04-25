<?php

/**
 * @package Epa
 */
namespace Epa\EndToEndTests\Support;

use Epa\Observer;
use Epa\EventMapper;
use Epa\Plugin;

/**
 * @package Epa
 */
class SuccessLoginLogger implements Plugin
{
	private $log = '';

	public function register(EventMapper $mapper)
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