<?php

namespace Epa;

class SampleUseTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @test
     */
    public function sampleApplicationUsingEpa(): void
    {
        // A *plugin* registers one or more observers for an event. When the
        // event happens, the callbacks are called.
        //
        // An *event* is an object that is passed to the observers by an observable when
        // something of interest has happened.
        //
        // An *observer* watches for events and is notified when an event happens.
        //
        // An *observable* is an object that is observed by an observer for one or more
        // events that may happen. It notifies the observers of the event.

        // We'll use a login class that is observable. It implements the `Observable`
        // interface meaning we can add observers to it. These are notified of login
        // attempts.
        $login = new \Epa\Login();

        // Two styles can be implemented.
        //
        // # Observer style
        //
        // We can add an observer to our login directly since it implements the
        // `Observer` interface. This observer then gets notified of any event happening.

        $logObserver = new \Epa\FailedLoginLogger();
        $login->addObserver($logObserver);

        $login->login('foo', 'bar');
        $this->assertEquals('failure for foo:bar', $logObserver->getLog());

        // # Plugin style
        //
        // The EventDispatcher is an interface that extends the observer interface and
        // thus can be added like the above `SuccessLoginLogger`. It listens to events
        // but dispatches the events to plugins. Plugins register themselves with
        // the EventDispatcher with `addPlugin`. The EventDispatcher then calls
        // them back giving these plugins the chance to register callbacks for certain
        // events. That means that it listens to events and notifies all callbacks
        // only when a certain event happened they are interested in. It provides
        // a central point to register plugins to have callbacks notified of specific events.
        //
        // Plugins register callbacks to events and this registration is by
        // the class name of the events (this can be changed, see below).

        $eventDispatcher = \Epa\EventDispatcherFactory::create();
        $login->addObserver($eventDispatcher); // EventDispatcher = observer style

        // The `SuccessLoginLogger` implements the `Plugin` interface and
        // can thus be registered with the EventDispatcher and adds a callback
        // for a certain event:
        //
        // $mapper->registerForEvent(
        //     'Epa\\EndToEndTests\\Support\\LoginEvent', $this->handleSuccessLogin()
        // );

        $logPlugin = new \Epa\SuccessLoginLogger();
        $eventDispatcher->addPlugin($logPlugin);

        $login->login('bar', 'baz');
        $this->assertEquals('success for bar:baz', $logPlugin->getLog());

        // It is possible to add plugins that register callbacks for events
        // thrown by the EventDispatcher itself. One possible use of this is to
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
        // $mapper
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
