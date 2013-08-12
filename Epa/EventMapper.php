<?php

/**
 * @package Epa
 */
namespace Epa;

/**
 * @package Epa
 */
interface EventMapper
{
	/**
	 * When an event is 'thrown', the callbacks will be notified of the
	 * event with `$callback($event)`.
	 * 
	 * @param string $event
	 * @param Callable $callback
	 * @return CallbackPosition
	 */
	public function registerForEvent($event, Callable $callback);
}