<?php

namespace Epa;

/**
 * Factory class for easy creation of an `EventDispatcher`.
 */
class EventDispatcherFactory
{
    /**
     * Creates an `EventDispatcher`.
     *
     * @retun \Epa\Api\EventDispatcher
     */
    public static function create()
    {
        return new \Epa\EventDispatcher ();
    }
}
