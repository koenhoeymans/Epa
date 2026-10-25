<?php

namespace Epa;

class EventDispatcherTest extends \PHPUnit\Framework\TestCase
{
    private $eventDispatcher;

    private $fooEvent;

    public function setup(): void
    {
        $this->eventDispatcher = new \Epa\EventDispatcher();
        $this->fooEvent = new FooEvent();
        $this->barEvent = new BarEvent();
    }

    public function testAsksPluginsToRegisterForAnEventWithCallback(): void
    {
        $plugin = $this->createMock('Epa\\Api\\Plugin');
        $plugin->expects($this->once())->method('registerHandlers');

        $this->eventDispatcher->addPlugin($plugin);
    }

    public function testRegisteredHandlersArePassedEventWhenItHappens(): void
    {
        $this->callbackCalled = false;

        $this->eventDispatcher->registerForEvent(
            'Epa\\FooEvent',
            function (FooEvent $event) {
                $this->callbackCalled = true;
            }
        );

        $this->eventDispatcher->notify($this->fooEvent);

        $this->assertTrue($this->callbackCalled);
    }

    public function testNotifiesHandlersOnlyForEventsTheyRegisteredFor(): void
    {
        $this->callbackCalled = false;

        $this->eventDispatcher->registerForEvent(
            'BarEvent',
            function (\Epa\FooEvent $event) {
                $this->callbackCalled = true;    
            }
        );

        $this->eventDispatcher->notify($this->fooEvent);

        $this->assertFalse($this->callbackCalled);
    }

    public function testThrowsApiNewEventEventWhenAnEventIsThrown(): void
    {
        $this->callbackCalled = false;

        $this->eventDispatcher->registerForEvent(
            'Epa\\Api\\NewEventEvent',
            function (\Epa\Api\NewEventEvent $event) {
                $this->callbackCalled = true;
            }
        );

        $this->eventDispatcher->notify($this->fooEvent);

        $this->assertTrue($this->callbackCalled, 'NewEventEven not thrown');
    }

    public function testNotifiesForAllEventNames(): void
    {
        $this->callbackOriginalCalled = false;
        $this->callbackAltCalled = false;

        $this->eventDispatcher->registerForEvent(
            'Epa\\Api\\NewEventEvent',
            function (\Epa\Api\NewEventEvent $event) {
                $event->addName('BarEvent');
            }
        );

        $this->eventDispatcher->registerForEvent(
            'Epa\\FooEvent',
            function (\Epa\FooEvent $event) {
                 $this->callbackOriginalCalled = true;
            }
        );
        $this->eventDispatcher->registerForEvent(
            'Epa\\BarEvent',
            function (\Epa\BarEvent $event) {
                 $this->callbackAltCalled = true;
            }
        );

        $this->eventDispatcher->notify($this->fooEvent);
        $this->eventDispatcher->notify($this->barEvent);

        $this->assertTrue(
            $this->callbackOriginalCalled,
            'Full eventname registrars not notified.'
        );
        $this->assertTrue(
            $this->callbackAltCalled,
            'Alternative eventname registrars not notified.'
        );
    }
}
