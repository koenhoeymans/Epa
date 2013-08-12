<?php

/**
 * @package Epa
 */
namespace Epa;

/**
 * This event is 'thrown' when there is a new event.
 * 
 * @package Epa
 */
class NewEventEvent implements Event
{
	private $names = array();

	public function __construct($name)
	{
		$this->names[] = $name;
	}

	/**
	 * Get the original name of the event.
	 * 
	 * @return string
	 */
	public function getOriginalName()
	{
		return $this->names[0];
	}

	/**
	 * Get all event names for this event.
	 * 
	 * @return string
	 */
	public function getNames()
	{
		return $this->names;
	}

	/**
	 * Adds an event name for this event.
	 * 
	 * @param string $name
	 */
	public function addName($name)
	{
		$this->names[] = $name;
	}
}