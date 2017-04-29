<?php

namespace Epa;

/**
 * Factory class for easy creation of an `EventDispatcher`.
 */
class EventDispatcherFactory
{
    /**
     * Creates an `EventDispatcher`.
     */
    public static function create(): \Epa\Api\EventDispatcher
    {
        return new EventDispatcher();
    }
}
