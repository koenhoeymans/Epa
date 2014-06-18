<?php

namespace Epa;

class NewEventEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function hasAllEventNames()
    {
        $event = new \Epa\NewEventEvent(array('foo', 'bar'));

        $this->assertEquals(array('foo', 'bar'), $event->getEventNames());
    }

    /**
     * @test
     */
    public function anEventNameCanBeAdded()
    {
        $event = new \Epa\NewEventEvent(array('foo'));
        $event->addName('bar');

        $this->assertEquals(array('foo', 'bar'), $event->getEventNames());
    }

    /**
     * @test
     */
    public function anEventNameCanBeRemoved()
    {
        $event = new \Epa\NewEventEvent(array('foo', 'bar', 'baz'));
        $event->removeName('baz');

        $this->assertEquals(array('foo', 'bar'), $event->getEventNames());
    }
}
