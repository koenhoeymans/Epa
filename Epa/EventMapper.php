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
	 * 
	 * @param string $event
	 * @param Callable $callback
	 * @return CallbackPosition
	 */
	public function registerForEvent($event, Callable $callback);
}