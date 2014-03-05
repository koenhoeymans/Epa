<?php

namespace Epa\Api;

/**
 * This event is 'thrown' when there is a new event.
 */
interface NewEventEvent extends \Epa\Api\Event
{
	/**
	 * Get the names of the event.
	 * 
	 * @return array
	 */
	public function getEventNames();

	/**
	 * Adds an event name for this event.
	 * 
	 * @param string $name
	 * 
	 * @return void
	 */
	public function addName($name);

	/**
	 * Removes an event name.
	 * 
	 * @param string $name
	 * 
	 * @return void
	 */
	public function removeName($name);
}