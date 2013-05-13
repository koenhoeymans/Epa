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
		# The EventDispatcher class is also an observer that can be added
		# like the above `SuccessLoginLogger`. It dispatches
		# the events to plugins that register themselves to get
		# notified when these events do occur. It provides a central point
		# to register plugins.
		#
		# Plugins register callbacks to events. The registration is by
		# the class name of the events (this can be changed, see below).

		$eventDispatcher = new \Epa\EventDispatcher();
		$login->addObserver($eventDispatcher); // EventDispatcher = observer style

		$logPlugin = new \Epa\EndToEndTests\Support\SuccessLoginLogger();
		$eventDispatcher->registerPlugin($logPlugin);

		# both styles work

		$login->login('foo', 'bar');
		$this->assertEquals('failure for foo:bar', $logObserver->getLog());

		$login->login('bar', 'baz');
		$this->assertEquals('success for bar:baz', $logPlugin->getLog());

		# It is possible to add plugins to the eventdispatcher itself. One
		# possible use of this is to change the way events are named. We
		# could change this from using the fully qualified class name to only
		# the classname itself (eg `Foo` instead of `\MyNamespace\Events\Foo`).

		$eventNameChanger = new \Epa\EndToEndTests\Support\EventNameChangerPlugin();
		$eventDispatcher->registerPlugin($eventNameChanger);

		# We'll add a loginLogger that registers itself for the event `LoginEvent`
		# instead of the standard `Epa\EndToEndTests\Support\LoginEvent`.

		$loginEventLogger = new \Epa\EndToEndTests\Support\LoginEventLogger();
		$eventDispatcher->registerPlugin($loginEventLogger);

		# The `LoginEventLogger` wants to be notified when a
		# `LoginEvent` is thrown. Our 'login' application throws the event
		# `\Epa\EndToEndTests\Support\LoginEvent` but our `EventNameChangerPlugin`
		# is notified of the `\Epa\NewEventEvent` and adds a new event name so that
		# callbacks registered for `LoginEvent` instead of the full class name
		# also get notified. Let's test it.

		$login->login('foo', 'bar');
		$this->assertEquals('last login was foo:bar', $loginEventLogger->getLastLogin());

		# A similar plugin already exists (`Epa\MetaEventNamePlugin`). It adds
		# event names that are specified inthe doc comments of the classes/interfaces
		# an event extends/implements. `@eventname` adds the interface or class name
		# as an event. `@eventName someName` adds the specified name as an event.
		#
		#     /**
		#      * @eventName Foo 
		#      */
		#
		# This will add the name 'Foo' as an eventname.
	}
}