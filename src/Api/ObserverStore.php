<?php

namespace Epa\Api;

/**
 * Implements `\Epa\Api\Observable`.
 * Provides a basic implementation of the observer pattern.
 */
trait ObserverStore
{
    protected $observers = array ();

    /**
     * Adds an observer.
     */
    public function addObserver(Observer $observer): void
    {
        $this->observers [] = $observer;
    }

    /**
     * Utility method.
     * Notifies all observers of an event.
     */
    protected function notify(Event $event): void
    {
        foreach ($this->observers as $observer) {
            $observer->notify($event);
        }
    }
}
