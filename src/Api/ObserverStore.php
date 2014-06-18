<?php

namespace Epa\Api;

/**
 * Implements `\Epa\Api\Observable`.
 * Provides a basic implementation of
 * the observer pattern.
 */
trait ObserverStore
{
    protected $observers = array ();

    /**
     * Adds an observer.
     *
     * @return void
     */
    public function addObserver(Observer $observer)
    {
        $this->observers [] = $observer;
    }

    /**
     * Utility method.
     * Notifies all observers of an event.
     *
     * @return void
     */
    protected function notify(Event $event)
    {
        foreach ($this->observers as $observer) {
            $observer->notify ( $event );
        }
    }
}
