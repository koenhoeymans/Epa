<?php

require_once('TestHelper.php');

class Epa_EndToEndTests_SampleUseTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function sampleApplicationUsingEpa()
	{
		$login = new \Epa\EndToEndTests\Support\Login();

		# # observer style
		#
		# Add an observer that wants to get notified to a class that supports
		# event notification.

		$logObserver = new \Epa\EndToEndTests\Support\FailedLoginLogger();
		$login->addObserver($logObserver);

		# # plugin style
		#
		# The EventDispatcher class is also an observer that can be added as
		# like the above `SuccessLoginLogger`. It dispatches
		# the events to plugins that register themselves to get
		# notified when these events do occur. It provides a central point
		# to register plugins.

		$eventDispatcher = new \Epa\EventDispatcher();
		$login->addObserver($eventDispatcher); // EventDispatcher = observer style

		$logPlugin = new \Epa\EndToEndTests\Support\SuccessLoginLogger();
		$eventDispatcher->registerPlugin($logPlugin);

		# both styles work

		$login->login('foo', 'bar');
		$this->assertEquals('failure for foo:bar', $logObserver->getLog());

		$login->login('bar', 'baz');
		$this->assertEquals('success for bar:baz', $logPlugin->getLog());
	}
}