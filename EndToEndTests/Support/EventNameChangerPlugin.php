<?php

namespace Epa\EndToEndTests\Support;

use Epa\Api\NewEventEvent;
use Epa\Api\EventDispatcher;
use Epa\Api\Plugin;

class EventNameChangerPlugin implements Plugin
{
	public function registerHandlers(EventDispatcher $mapper)
	{
		$mapper->registerForEvent('Epa\\Api\\NewEventEvent', function(NewEventEvent $event) {
			$this->handleEvent($event);
		});
	}

	private function handleEvent(NewEventEvent $event)
	{
		$names = $event->getEventNames();
		foreach ($names as $name)
		{
			$newName = substr(strrchr($name, '\\'), 1);
			$event->addName($newName);
		}
	}
}