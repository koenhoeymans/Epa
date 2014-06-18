<?php

namespace Epa\Api;

class ObserverStoreTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function notifiesObserversOfEvent()
    {
        $observableClass = new \Epa\ClassWithEvent();
        $observer = $this->getMock('Epa\\Api\\Observer');
        $event = $this->getMock('Epa\\Api\\Event');

        $observer->expects($this->once())->method('notify')->with($event);

        $observableClass->addObserver($observer);
        $observableClass->createEvent($event);
    }
}
