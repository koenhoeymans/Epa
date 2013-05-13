<?php

/**
 * @package Epa
 */
namespace Epa;

/**
 * @package Epa
 */
class MetaEventNamePlugin implements Plugin
{
	public function register(EventMapper $mapper)
	{
		$mapper->registerForEvent('Epa\\NewEventEvent', function(NewEventEvent $event) {
			$this->handleEvent($event);
		});
	}

	private function handleEvent(NewEventEvent $event)
	{
		$this->addDocCommentNames($event->getOriginalName(), $event);
		foreach (class_implements($event->getOriginalName()) as $implemented)
		{
			$this->addDocCommentNames($implemented, $event);
		}
		foreach (class_parents($event->getOriginalName()) as $extended)
		{
			$this->addDocCommentNames($extended, $event);
		}
	}

	private function addDocCommentNames($class, NewEventEvent $event)
	{
		$reflClass = new \ReflectionClass($class);
		$docComm = $reflClass->getDocComment();

		if(preg_match("@\n\s*\*\s*\@eventname\n@i", $docComm))
		{
			$event->addName($class);
		}

		preg_match_all(
			"@(?<=\n)\s*\*\s\@eventname\s+(?<name>\S+?)(?=\n)@i",
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