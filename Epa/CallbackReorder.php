<?php

/**
 * @package Epa
 */
namespace Epa;

/**
 * @package Epa
 */
class CallbackReorder implements CallbackPosition
{
	private $arr;

	private $eventName;

	private $callback;

	public function __construct(\ArrayObject $arr, $eventName, Callable $callback)
	{
		$this->arr = $arr;
		$this->eventName = $eventName;
		$this->callback = $callback;
	}

	public function first()
	{
		$arr = $this->arr->offsetGet($this->eventName);
		$key = array_search($this->callback, $arr);
		unset($arr[$key]);
		array_unshift($arr, $this->callback);
		$this->arr->offsetSet($this->eventName, $arr);
	}
}