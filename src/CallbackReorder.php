<?php

namespace Epa;

/**
 * Implementing the fluid interface of `Epa\Api\CallbackPosition`.
 */
class CallbackReorder implements \Epa\Api\CallbackPosition
{
    private $arr;

    private $eventName;

    private $callback;

    public function __construct(
        \ArrayObject $arr,
        $eventName,
        callable $callback
    ) {
        $this->arr = $arr;
        $this->eventName = $eventName;
        $this->callback = $callback;
    }

    /**
     *
     * @see \Epa\CallbackPosition::first()
     */
    public function first()
    {
        $arr = $this->arr->offsetGet($this->eventName);
        $key = array_search($this->callback, $arr);
        unset($arr[$key]);
        array_unshift($arr, $this->callback);
        $this->arr->offsetSet($this->eventName, $arr);
    }
}
