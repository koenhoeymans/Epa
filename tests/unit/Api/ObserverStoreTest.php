<?php

namespace Epa\Api;

class ObserverStoreTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function notifiesObserversOfEvent()
    {
        $observableClass = new \Epa\ClassWithEvent();
        $observer = $this->createMock('Epa\\Api\\Observer');
        $event = $this->createMock('Epa\\Api\\Event');

        $observer->expects($this->once())->method('notify')->with($event);

        $observableClass->addObserver($observer);
        $observableClass->createEvent($event);
    }
}
