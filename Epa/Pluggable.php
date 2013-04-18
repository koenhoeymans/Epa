<?php

/**
 * @package Epa
 */
namespace Epa;

/**
 * @package Epa
 */
trait Pluggable
{
	protected $observers = array();

	public function addObserver(Observer $observer)
	{
		$this->observers[] = $observer;
	}

	protected function notify(Event $event)
	{
		foreach ($this->observers as $observer)
		{
			$observer->notify($event);
		}
	}
}