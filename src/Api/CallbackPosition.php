<?php

namespace Epa\Api;

/**
 * Part of the fluent interface when registering callbacks starting with
 * `\Epa\Api\EventDispatcher::registerForEvent`.
 *
 * The position of the callback in the list of callbacks for an event can be
 * specified when one needs to make sure a callback is e.g. called before other
 * callbacks.
 *
 * Example use:
 *
 *     $eventDispatcher = \Epa\Api\EventDispatcherFactory:create();
 *     $eventDispatcher->registerForEvent('Foo\BarEvent', $myCallback)->first();
 */
interface CallbackPosition
{
    /**
     * Adds the callback first.
     * Note that it is possible that another callback
     * afterwards also asks to be called first. So one cannot have 100%
     * guarantee that it will really be called first when there are other
     * callbacks registering for the event.
     */
    public function first(): void;
}
