<?php

require_once('TestHelper.php');

class Epa_UnitTestsTests_PluggableTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function notifiesObserversOfEvent()
	{
		$observableClass = new \Epa\UnitTests\Support\ClassWithEvent();
		$observer = $this->getMock('Epa\\Observer');
		$event = $this->getMock('Epa\\Event');

		$observer->expects($this->once())->method('notify')->with($event);

		$observableClass->addObserver($observer);
		$observableClass->createEvent($event);
	}
}