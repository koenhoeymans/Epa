<?php

namespace Epa;

class NewEventEventTest extends \PHPUnit\Framework\TestCase
{
    public function testHasAllEventNames(): void
    {
        $event = new \Epa\NewEventEvent(array('foo', 'bar'));

        $this->assertEquals(array('foo', 'bar'), $event->getEventNames());
    }

    public function testAnEventNameCanBeAdded(): void
    {
        $event = new \Epa\NewEventEvent(array('foo'));
        $event->addName('bar');

        $this->assertEquals(array('foo', 'bar'), $event->getEventNames());
    }

    public function testAnEventNameCanBeRemoved(): void
    {
        $event = new \Epa\NewEventEvent(array('foo', 'bar', 'baz'));
        $event->removeName('baz');

        $this->assertEquals(array('foo', 'bar'), $event->getEventNames());
    }
}
