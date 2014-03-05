<?php

namespace Epa\Api;

/**
 * A plugin registers handlers for a certain event with the `EventDispatcher`.
 */
interface Plugin
{
	/**
	 * Passes the `EventDispatcher` so it can register handlers for an event.
	 * 
	 * @param \Epa\Api\EventDispatcher $eventDispatcher
	 * 
	 * @return void
	 */
	public function registerHandlers(\Epa\Api\EventDispatcher $eventDispatcher);
}