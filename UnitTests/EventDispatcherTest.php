<?php

require_once('TestHelper.php');

class Epa_UnitTests_EventDispatcherTest extends PHPUnit_Framework_TestCase
{
	public function setup()
	{
		$this->eventDispatcher = new \Epa\EventDispatcher();
	}

	/**
	 * @test
	 */
	public function asksPluginsToRegisterForAnEventWithCallback()
	{
		$plugin = $this->getMock('Epa\\Api\\Plugin');
		$plugin
			->expects($this->once())
			->method('registerHandlers');

		$this->eventDispatcher->addPlugin($plugin);
	}

	/**
	 * @test
	 */
	public function registeredHandlersArePassedEventWhenItHappens()
	{
		$this->callbackCalled = false;
		$event = $this->getMockBuilder('Epa\\Api\\Event')
			->setMockClassName('FooEvent')
			->getMock();
		$this->eventDispatcher->registerForEvent('FooEvent', function(FooEvent $event) {
			$this->callbackCalled = true;
		});

		$this->eventDispatcher->notify($event);

		if (!$this->callbackCalled)
		{
			$this->fail();
		}
	}

	/**
	 * @test
	 */
	public function notifiesHandlersOnlyForEventsTheyRegisteredFor()
	{
		$event = $this->getMockBuilder('Epa\\Event')
			->setMockClassName('FooEvent')
			->getMock();
		$this->eventDispatcher->registerForEvent('BarEvent', function(FooEvent $event) {
			$this->fail();
		});

		$this->eventDispatcher->notify($event);
	}

	/**
	 * @test
	 */
	public function throwsApiNewEventEventWhenAnEventIsThrown()
	{
		$this->callbackCalled = false;

		$this->eventDispatcher->registerForEvent(
			'Epa\\Api\\NewEventEvent',
			function(\Epa\Api\NewEventEvent $event) {
				$this->callbackCalled = true;
			}
		);

		$this->eventDispatcher->notify($this->getMock('Epa\\Api\\Event'));

		if (!$this->callbackCalled)
		{
			$this->fail('NewEventEvent not thrown.');
		}
	}

	/**
	 * @test
	 */
	public function notifiesForAllEventNames()
	{
		$this->callbackOriginalCalled = false;
		$this->callbackAltCalled = false;

		$event = $this->getMockBuilder('Epa\\Api\\Event')
			->setMockClassName('FooEvent')
			->getMock();

		$this->eventDispatcher->registerForEvent(
			'Epa\\Api\\NewEventEvent', function(\Epa\NewEventEvent $event
		) {
			$event->addName('BarEvent');
		});

		$this->eventDispatcher->registerForEvent(
			'FooEvent', function(FooEvent $event
		) {
			$this->callbackOriginalCalled = true;
		});
		$this->eventDispatcher->registerForEvent(
			'BarEvent', function(FooEvent $event
		) {
			$this->callbackAltCalled = true;
		});

		$this->eventDispatcher->notify($event);

		if (!$this->callbackOriginalCalled)
		{
			$this->fail('Full eventname registars not notified.');
		}
		if (!$this->callbackAltCalled)
		{
			$this->fail('Alternative eventname registrars not notified.');
		}
	}
}