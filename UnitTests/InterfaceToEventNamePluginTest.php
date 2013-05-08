<?php

require_once('TestHelper.php');

class Epa_UnitTests_InterfaceToEventNameTest extends PHPUnit_Framework_TestCase
{
	public function setup()
	{
		$this->plugin = new \Epa\InterfaceToEventNamePlugin();
	}

	/**
	 * @test
	 */
	public function addsInterfaceWithEventDocCommentAsEventName()
	{
		$newEventEvent = new \Epa\NewEventEvent(
			'Epa\\UnitTests\\Support\\EventImplementingInterface'
		);
		$mockEventMapper = new \Epa\UnitTests\Support\MockEventMapper();

		$this->plugin->register($mockEventMapper);
		$callback = $mockEventMapper->getCallback();
		$callback($newEventEvent);

		$this->assertEquals(
			array(
				'Epa\\UnitTests\\Support\\EventImplementingInterface',
				'Epa\\UnitTests\\Support\\InterfaceWithDocCommentEvent',
				'Foo'
			),
			$newEventEvent->getNames()
		);
	}
}