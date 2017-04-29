<?php

namespace Epa\Api;

/**
 * This event is 'thrown' when there is a new event.
 */
interface NewEventEvent extends Event
{
    /**
     * Get the names of the event.
     */
    public function getEventNames(): array;

    /**
     * Adds an event name for this event.
     */
    public function addName(string $name): void;

    /**
     * Removes an event name.
     */
    public function removeName(string $name): void;
}
