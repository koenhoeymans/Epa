<?php

require_once dirname(__FILE__)
		. DIRECTORY_SEPARATOR . '..'
		. DIRECTORY_SEPARATOR . 'TestHelper.php';

class Epa_UnitTests_Api_ObserverStoreTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function notifiesObserversOfEvent()
	{
		$observableClass = new \Epa\UnitTests\Support\ClassWithEvent();
		$observer = $this->getMock('Epa\\Api\\Observer');
		$event = $this->getMock('Epa\\Api\\Event');

		$observer->expects($this->once())->method('notify')->with($event);

		$observableClass->addObserver($observer);
		$observableClass->createEvent($event);
	}
}