<?php

require_once('TestHelper.php');

class Epa_UnitTestsTests_EventDispatcherTest extends PHPUnit_Framework_TestCase
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
		$plugin = $this->getMock('Epa\\Plugin');
		$plugin->expects($this->once())
			->method('register');

		$this->eventDispatcher->registerPlugin($plugin);
	}

	/**
	 * @test
	 */
	public function registeredCallbacksArePassedEventWhenItHappens()
	{
		$this->callbackCalled = false;
		$event = $this->getMockBuilder('Epa\\Event')
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
	public function notifiesOnlyForRegisteredEvents()
	{
		$event = $this->getMockBuilder('Epa\\Event')
			->setMockClassName('FooEvent')
			->getMock();
		$this->eventDispatcher->registerForEvent('BarEvent', function(FooEvent $event) {
			$this->fail();
		});

		$this->eventDispatcher->notify($event);
	}
}