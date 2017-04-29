<?php

namespace Epa\Api;
use Fjor\Api\Dsl\GivenClassOrInterface\ThenUse;

/**
 * Needs to be implemented by a class that wants to make use of observers.
 * It follows the observer pattern. Most likely it will have the
 * `ObserverStore` as an observer to notify of events happening.
 */
interface Observable
{
    /**
     * Adds an observer.
     * The observer should be notified of any events.
     */
    public function addObserver(Observer $observer): void;
}
