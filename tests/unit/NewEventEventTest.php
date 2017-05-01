<?php

namespace Epa;

class NewEventEventTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function hasAllEventNames(): void
    {
        $event = new \Epa\NewEventEvent(array('foo', 'bar'));

        $this->assertEquals(array('foo', 'bar'), $event->getEventNames());
    }

    /**
     * @test
     */
    public function anEventNameCanBeAdded(): void
    {
        $event = new \Epa\NewEventEvent(array('foo'));
        $event->addName('bar');

        $this->assertEquals(array('foo', 'bar'), $event->getEventNames());
    }

    /**
     * @test
     */
    public function anEventNameCanBeRemoved(): void
    {
        $event = new \Epa\NewEventEvent(array('foo', 'bar', 'baz'));
        $event->removeName('baz');

        $this->assertEquals(array('foo', 'bar'), $event->getEventNames());
    }
}
