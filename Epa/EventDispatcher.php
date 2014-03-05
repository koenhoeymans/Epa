<?php

namespace Epa;

class EventDispatcher implements \Epa\Api\Observer, \Epa\Api\EventDispatcher
{
	private $observers;

	public function __construct()
	{
		$this->observers = new \ArrayObject();
	}

	/**
	 * @see \Epa\Api\Observer::notify()
	 */
	public function notify(\Epa\Api\Event $event)
	{
		$newEventEvent = new \Epa\NewEventEvent(
			array_merge(
				array(get_class($event)),
				class_parents($event),
				array_values(class_implements($event))
			)
		);

		$this->notifyObservers($newEventEvent, 'Epa\\Api\\NewEventEvent');

		foreach ($newEventEvent->getEventNames() as $eventName)
		{
			$this->notifyObservers($event, $eventName);
		}
	}

	/**
	 * @see \Epa\Api\EventDispatcher::registerForEvent()
	 */
	public function registerForEvent($event, Callable $callback)
	{
		$this->observers[$event][] = $callback;
		return new CallbackReorder($this->observers, $event, $callback);
	}

	/**
	 * @see \Epa\Api\EventDispatcher::addPlugin()
	 */
	public function addPlugin(\Epa\Api\Plugin $plugin)
	{
		$plugin->registerHandlers($this);
	}

	private function notifyObservers(\Epa\Api\Event $event, $eventName)
	{
		if (!isset($this->observers[$eventName]))
		{
			return;
		}
		foreach ($this->observers[$eventName] as $callback)
		{
			$callback($event);
		}
	}
}