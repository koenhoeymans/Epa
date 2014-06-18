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
     *
     * @param \Epa\Api\Plugin $plugin
     *
     * @return void
     */
    public function addPlugin(\Epa\Api\Plugin $plugin);

    /**
     * Register handlers (a callback) for an event.
     *
     * @param string   $event
     * @param callback $handler
     *
     * @return \Epa\Api\CallbackPosition
     */
    public function registerForEvent($event, Callable $handler);
}
