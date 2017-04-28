<?php

namespace Epa\Api;

/**
 * The EventDispatcher passes events to callbacks that register for it.
 *
 * An implementation is provided by using `\Epa\EventDispatcherFactory::create()`.
 *
 * It can be passed in the constructor or as an observer.
 */
interface EventDispatcher extends Observer
{
    /**
     * Add a plugin.
     * A plugin registers handlers for a certain event.
     */
    public function addPlugin(\Epa\Api\Plugin $plugin): void;

    /**
     * Register handlers (a callback) for an event.
     */
    public function registerForEvent(string $event, callable $handler): \Epa\Api\CallbackPosition;
}
