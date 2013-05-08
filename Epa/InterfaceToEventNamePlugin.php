<?php

/**
 * @package Epa
 */
namespace Epa;

/**
 * @package Epa
 */
class InterfaceToEventNamePlugin implements Plugin
{
	public function register(EventMapper $mapper)
	{
		$mapper->registerForEvent('Epa\\NewEventEvent', function(NewEventEvent $event) {
			$this->handleEvent($event);
		});
	}

	private function handleEvent(NewEventEvent $event)
	{
		foreach (class_implements($event->getOriginalName()) as $implemented)
		{
			if (!interface_exists($implemented))
			{
				continue;
			}
			$this->addDocCommentNames($implemented, $event);
		}
	}

	private function addDocCommentNames($interface, NewEventEvent $event)
	{
		$reflClass = new \ReflectionClass($interface);
		$docComm = $reflClass->getDocComment();

		if(preg_match("@\n\s*\*\s*\@event\n@", $docComm))
		{
			$event->addName($interface);
		}

		preg_match_all(
			"@(?<=\n)\s*\*\s\@eventName\s+(?<name>.+?)(?=\n)@",
			$docComm,
			$matches,
			PREG_PATTERN_ORDER
		);
		if (isset($matches['name']))
		{
			foreach ($matches['name'] as $name)
			{
				$event->addName($name);
			}
		}
	}
}