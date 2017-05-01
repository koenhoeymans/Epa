<?php

namespace Epa;

class SampleUseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function sampleApplicationUsingEpa(): void
    {
        // We create a very simple login class which notifies of login
        // attempts that were made. The alerts of login attempts will be send to the observers
        // of this class while the login class itself is observable by these observers for these login events.
        // This means that the login class must implement the `Observable` interface while
        // the objects that are waiting to be notified of login attempts must implement
        // the `Observer` interface. When a login attempt has happened the login class
        // must create an event that can be passed to the observers so they are notified. The event is
        // a class that implements the `Event` interface.

        // Our login class has a login and password hardcoded for simplicity. When a login
        // attempt is made it create a new `LoginEvent` and notifies all observers.
        $login = new \Epa\Login();

        // Our login class uses the trait `ObserverStore` which already implements
        // the `Observable` interface and adds a utility method to notify all
        // observers of the event. To become an observable class then there really isn't
        // much needed: use the trait and add the observable interface as implemented.

        // A class that logs failed login attempts could be added as an observer.
        $failedLoginLogger = new \Epa\FailedLoginLogger();
        $login->addObserver($failedLoginLogger);

        // Now when a our login system notifies observers of a login, the failed
        // login logger will examine the event and in case it was indeed a failed
        // login attempt log all failed logins.
        $login->login('foo', 'bar');
        $this->assertEquals('failure for foo:bar', $failedLoginLogger->getLog());

        // This simple application has:
        //  * an observable: the login class, helped by a trait 'ObserverStore'
        //  * an observer: the failed login logger class
        //  * an event: created by the login class and passed to the observers

        // A way to extend the setup is to use an `EventDispatcher`. This class
        // is also an observer so it can be added to any observables but it does
        // more. It dispatches the events it gets notified off and only to those interested in it.
        // A `Plugin` is what registers the code that will handle an event.
        $eventDispatcher = \Epa\EventDispatcherFactory::create();
        $login->addObserver($eventDispatcher);

        // Instead of adding more observers, the EventDispatcher is added everywhere
        // as an observer and plugins register themselves only with the EventDispatcher.
        $logPlugin = new \Epa\SuccessLoginLogger();
        $eventDispatcher->addPlugin($logPlugin);

        $login->login('bar', 'baz');
        $this->assertEquals('success for bar:baz', $logPlugin->getLog());

        // When a plugin is added to the event dispatcher it is asked to register
        // a callback for a certain event.

        // The `SuccessLoginLogger` implements the `Plugin` interface and
        // can thus be registered with the EventDispatcher and adds a callback
        // for a certain event:
        //
        // $mapper->registerForEvent(
        //     'Epa\\LoginEvent', $this->handleSuccessLogin()
        // );

        // It is possible to add plugins that register callbacks for events
        // thrown by the EventDispatcher itself. An event thrown by the event
        // dispatcher is the `NewEventEvent`. One possible use of this is to
        // change the way events are named. We could change this from using
        // the fully qualified class name to only the classname itself
        // (eg `Foo` instead of `\MyNamespace\Events\Foo`). That's because the
        // EventDispatcher throws the `Epa\Api\NewEventEvent` when it is notified
        // of a new event. This event has the option to add an event name.

        $eventNameChanger = new \Epa\EventNameChangerPlugin();
        $eventDispatcher->addPlugin($eventNameChanger);

        // We'll add a loginLogger that registers a callback for the event `LoginEvent`
        // instead of the standard `Epa\EndToEndTests\Support\LoginEvent`. The
        // EventNameChangerPlugin added this version of event names to events.

        $loginEventLogger = new \Epa\LoginEventLogger();
        $eventDispatcher->addPlugin($loginEventLogger);

        // The `LoginEventLogger` wants to be notified when a
        // `LoginEvent` is thrown. Our 'login' application throws the event
        // `\Epa\EndToEndTests\Support\LoginEvent` but our `EventNameChangerPlugin`
        // is notified of the `\Epa\Api\NewEventEvent` and adds a new event name so that
        // callbacks registered for `LoginEvent` (instead of the full class name)
        // also get notified.

        $login->login('foo', 'bar');
        $this->assertEquals('last login was foo:bar', $loginEventLogger->getLastLogin());

        // When you register a callback for an event the callbacks are notified in
        // order of registration. Sometimes you may want to add a callback before
        // any other callback. Inside the plugin you can achieve this using `first`:
        //
        // $eventDispatcher
        // ->registerForEvent('login', function () {$this->handleEvent($event); })
        // ->first();
        //
        // Let's add another plugin that registers a callback for the event
        // `LoginEvent` but adds the callback before the one `LoginEventLogger`
        // registers (using `first`). It will change the username used to log in.

        $loginNameChanger = new \Epa\LoginNameChanger();
        $eventDispatcher->addPlugin($loginNameChanger);

        $login->login('foo', 'bar');
        $this->assertEquals('last login was baz:bar', $loginEventLogger->getLastLogin());
    }
}
