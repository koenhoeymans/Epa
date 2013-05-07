<?php

/**
 * @package Epa
 */
namespace Epa\EndToEndTests\Support;

use Epa\NewEventEvent;
use Epa\EventMapper;

use Epa\Plugin;

/**
 * @package Epa
 */
class EventNameChangerPlugin implements Plugin
{
	public function register(EventMapper $mapper)
	{
		$mapper->registerForEvent('Epa\\NewEventEvent', function(NewEventEvent $event) {
			$this->handleEvent($event);
		});
	}

	private function handleEvent(NewEventEvent $event)
	{
		$name = $event->getOriginalName();
		$newName = substr(strrchr($name, '\\'), 1);

		$event->addName($newName);
	}
}