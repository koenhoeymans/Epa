<?php

/**
 * @package Epa
 */
namespace Epa;

/**
 * @package Epa
 */
class EventDispatcher implements Observer, EventMapper
{
	private $observers;

	public function __construct()
	{
		$this->observers = new \ArrayObject();
	}

	/**
	 * @see \Epa\Observer::notify()
	 */
	public function notify(Event $event)
	{
		$newEventEvent = new \Epa\NewEventEvent(get_class($event));

		$this->notifyObservers($newEventEvent, 'Epa\\NewEventEvent');

		foreach ($newEventEvent->getNames() as $eventName)
		{
			$this->notifyObservers($event, $eventName);
		}
	}

	/**
	 * @see \Epa\EventMapper::registerForEvent()
	 */
	public function registerForEvent($event, Callable $callback)
	{
		$this->observers[$event][] = $callback;
		return new CallbackReorder($this->observers, $event, $callback);
	}

	/**
	 * Register a plugin. The plugin will be asked to register callbacks for events
	 * (@see \Epa\EventDispatcher::registerForEvent) so the callbacks will be
	 * called when the event happens.
	 * 
	 * @param Plugin $plugin
	 */
	public function registerPlugin(Plugin $plugin)
	{
		$plugin->register($this);
	}

	private function notifyObservers(Event $event, $eventName)
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