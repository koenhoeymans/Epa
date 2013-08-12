<?php

/**
 * @package Epa
 */
namespace Epa\UnitTests\Support;

use Epa\EventMapper;

/**
 * @package Epa
 */
class MockEventMapper implements EventMapper
{
	private $event;

	private $callback;

	public function registerForEvent($event, Callable $callback)
	{
		$this->event = $event;
		$this->callback = $callback;
	}

	public function getCallback()
	{
		return $this->callback;
	}
}