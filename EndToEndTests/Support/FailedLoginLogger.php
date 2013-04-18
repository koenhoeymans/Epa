<?php

/**
 * @package Epa
 */
namespace Epa\EndToEndTests\Support;

use Epa\Observer;
use Epa\Event;

/**
 * @package Epa
 */
class FailedLoginLogger implements Observer
{
	private $log;

	public function notify(Event $event)
	{
		if (!$event instanceof \Epa\EndToEndTests\Support\LoginEvent)
		{
			return;
		}

		if (!$event->loginFailed())
		{
			return;
		}

		$this->log = 'failure for ' . $event->getName() . ':' . $event->getPass();
	}

	public function getLog()
	{
		return $this->log;
	}
}