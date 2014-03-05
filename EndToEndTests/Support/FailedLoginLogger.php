<?php

namespace Epa\EndToEndTests\Support;

use Epa\Api\Observer;
use Epa\Api\Event;

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