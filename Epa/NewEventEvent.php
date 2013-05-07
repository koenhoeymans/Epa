<?php

/**
 * @package Epa
 */
namespace Epa;

/**
 * @package Epa
 */
class NewEventEvent implements Event
{
	private $names = array();

	public function __construct($name)
	{
		$this->names[] = $name;
	}

	public function getOriginalName()
	{
		return $this->names[0];
	}

	public function getNames()
	{
		return $this->names;
	}

	public function addName($name)
	{
		$this->names[] = $name;
	}
}