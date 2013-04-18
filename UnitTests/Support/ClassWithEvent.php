<?php

/**
 * @package Epa
 */
namespace Epa\UnitTests\Support;

use Epa\Pluggable;
use Epa\Event;

/**
 * @package Epa
 */
class ClassWithEvent
{
	use Pluggable;

	public function createEvent(Event $event)
	{
		$this->notify($event);
	}
}