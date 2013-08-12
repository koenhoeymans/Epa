<?php

require_once('TestHelper.php');

class Epa_EndToEndTests_SampleUseTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function sampleApplicationUsingEpa()
	{
		# First some definitions. A plugin registers one or more callbacks for an event.
		# An event is an object that is 'thrown' when you want to notify that
		# something of potential interest is going to happen/is happening/happened.
		# Observers are notified when an event happens.

		# We'll use a login class that is observable. It implements the `Observable`
		# interface meaning we can add observers to it. These are notified of login
		# attempts.
		$login = new \Epa\EndToEndTests\Support\Login();

		# # Observer style
		#
		# We can add an observer to our login directly. It implements the
		# `Observer` interface. It then gets notified of any event happening.

		$logObserver = new \Epa\EndToEndTests\Support\FailedLoginLogger();
		$login->addObserver($logObserver);

		$login->login('foo', 'bar');
		$this->assertEquals('failure for foo:bar', $logObserver->getLog());

		# # Plugin style
		#
		# The EventDispatcher is a class that is also an observer and thus can
		# be added like the above `SuccessLoginLogger`. It listens to events
		# but dispatches the events to plugins. Plugins register themselves with
		# the EventDispatcher with `registerPlugin`. The EventDispatcher then calls
		# them back giving these plugins the chance to register callbacks for certain
		# events. That means that instead it listens to events (like the log observer
		# above, and then notifies all callbacks only when a certain event happened
		# they are interested in. It provides a central point
		# to register plugins to have callbacks notified of specific events.
		#
		# Plugins register callbacks to events and this registration is by
		# the class name of the events (this can be changed, see below).

		$eventDispatcher = new \Epa\EventDispatcher();
		$login->addObserver($eventDispatcher); // EventDispatcher = observer style

		# The `SuccessLoginLogger` implements the `Plugin` interface and
		# can thus be registered with the EventDispatcher and adds a callback
		# for a certain event:
		#
		#     $mapper->registerForEvent(
		#         'Epa\\EndToEndTests\\Support\\LoginEvent', $this->handleSuccessLogin()
		#     );

		$logPlugin = new \Epa\EndToEndTests\Support\SuccessLoginLogger();
		$eventDispatcher->registerPlugin($logPlugin);

		$login->login('bar', 'baz');
		$this->assertEquals('success for bar:baz', $logPlugin->getLog());

		# It is possible to add plugins that register callbacks for events
		# thrown by the EventDispatcher itself. One possible use of this is to
		# change the way events are named. We could change this from using
		# the fully qualified class name to only the classname itself
		# (eg `Foo` instead of `\MyNamespace\Events\Foo`). That's because the
		# EventDispatcher throws the `Epa\\NewEventEvent` when it is notified
		# of a new event. This event has the option to add an event name.

		$eventNameChanger = new \Epa\EndToEndTests\Support\EventNameChangerPlugin();
		$eventDispatcher->registerPlugin($eventNameChanger);

		# We'll add a loginLogger that registers a callback for the event `LoginEvent`
		# instead of the standard `Epa\EndToEndTests\Support\LoginEvent`. The
		# EventNameChangerPlugin added this version of event names to events.

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

		# When you register a callback for an event the callbacks are notified in
		# order of registration. Sometimes you may want to add a callback before
		# any other callback. Inside the plugin you can achieve this using `first`:
		#
		#     $mapper
		#       ->registerForEvent('login', function() {$this->handleEvent($event); })
		#       ->first();
		#
		# Let's add another plugin that registers a callback for the event
		# `LoginEvent`, like the `LoginEventLogger` above, but adds it before and
		# has the callback change the username.

		$loginNameChanger = new \Epa\EndToEndTests\Support\LoginNameChanger();
		$eventDispatcher->registerPlugin($loginNameChanger);

		$login->login('foo', 'bar');
		$this->assertEquals('last login was baz:bar', $loginEventLogger->getLastLogin());
	}
}