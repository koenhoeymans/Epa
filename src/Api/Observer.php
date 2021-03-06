<?php

namespace Epa\Api;

/**
 * Part of the observer pattern.
 * An observer observes an observable and is notified of events.
 */
interface Observer
{
    /**
     * To notify the observer of an event.
     */
    public function notify(Event $event): void;
}
