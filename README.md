# EPA


## What is it?

EPA stands for Event-based Plugin Architecture. These are some simple classes
and interfaces that together form a whole that can be used to let plugins
enhance your code. The plugins can register themselves for certain events and are
notified of and passed the event when it occures.


## Using it

### Events and the observer pattern

Let's first look at what an event is. Actually an event can be just about everything you
want it to be. It just needs to implement `Epa\Event` but has no defined methods. This
can be an event:

	use Epa\Api\Event;

	class FailedLogin implements Event
	{
		private $username;
		private $loginSucceeded;

		public function __construct($username, $loginSucceeded)
		{
			$this->username = $username;
			$this->loginSucceeded = $loginSucceeded;
		}

		public function getUserName()
		{
			return $this->username;
		}

		public function loginSucceeded()
		{
			return $this->loginSucceeded;
		}
	}

A plugin that logs failed logins could make use of this. Another event might
allow a plugin to change the content of a post:

	use Epa\Api\Event;

	class BeforePublishPostEvent implements Event
	{
		private $postContent;

		public function __construct($postContent)
		{
			$this->postContent = $postContent;
		}

		public function getPostContent()
		{
			return $this->postContent;
		}

		public function setPostContent($postContent)
		{
			$this->postContent = $postContent;
		}
	}

For each class that you allow a plugin to change or notify of something you use
the interface `Epa\Api\Observable` and the trait `Epa\Api\ObserverStore`
to implement it.

	use Epa\Api\Observable;
	use Epa\Api\ObserverStore;

	class MyClass implements Observable
	{
		use ObserverStore;
	}

Observers implement `\Epa\Api\Observer`. It has one method `notify`.

	class SampleObserver implements \Epa\Api\Observer
	{
		public function notify(\Epa\Api\Event $event)
		{
			echo 'following event observed: ' . get_class($event);
		}
	}

	$myClass = new MyClass();
	$myClass->addObserver($new SampleObserver());

When your class has something interesting for observers you can notify
them of the event by using the `ObserverStore::notify` method using
the event as an argument.

	use Epa\Api\Observable;
	use Epa\Api\ObserverStore;

	class BlogPostDisplay implements Observable
	{
		use ObserverStore;

		public function display($postContent)
		{
			$event = new EditPostContentEvent($postContent);
			// ...
			$this->notify(new BeforePublishPostEvent($event));
			// ...
		}
	}

Now all observers will be notified and be able to do something with the
post content. This is the classic observer pattern in action.


### Plugins And the EventDispatcher

The `EventDispatcher`, which implements `\Epa\Api\Observer`, is used to
dispatch events to callbacks that register for them. An instance can be
created using a factory:

	$eventDispatcher = \Epa\Api\EventDispatcherFactory::create();

A `Plugin` registers callbacks for certain events. You can create one by implementing
the `\Epa\Api\Plugin` interface.

	use Epa\Api\Plugin;
	use Epa\Api\EventDispatcher

	class FailedLoginLogger implements Plugin
	{
		public function registerHandlers(EventDispatcher $mapper)
		{
			$mapper->registerForEvent('FailedLogin', function(FailedLogin $event) {
				$this->handleFailedLoginEvent($event);
			});
		}

		private function handleFailedLoginEvent(FailedLogin $event)
		{
			// $event->getUserName();
			// write to log etc
		}
	{

You can see that the plugin calls the `registerForEvent` method on the `EventDispatcher`
to register the callbacks for a certain event. Every time the `EventDispatcher` is
notified of an event it activates the callbacks that registered for the event.

Since a plugin can register more than one callback it is possible to use
`EventDispatcher::addPlugin`. This will in its turn call `Plugin::registerHandlers`
so the plugin can register the callbacks.

	$eventDispatcher->addPlugin(new FailedLoginLogger());

The event names the `EventDispatcher` uses are the class names of the event that
is 'thrown' by the observable classes.

The `EventDispatcher` can be passed to your classes by constructor injection or by
using the observer pattern mentioned above and pass it as an observer.

	class LoginChecker
	{
		private $eventDispatcher;

		public function __construct(\Epa\Api\EventDispatcher $eventDispatcher)
		{
			$this->eventDispatcher = $eventDispatcher;
		}

		public function check($username, $password)
		{
			$loginAttempt = new LoginAttemp($username, $password);
			$this->eventDispatcher->notify($loginAttempt);

			// do more stuff
		}
	}

	$loginChecker = new LoginChecker($eventDispatcher);

Versus

	class LoginChecker implements \Epa\Api\Observable
	{
		use \Epa\Api\ObserverStore;

		public function check($username, $password)
		{
			$loginAttempt = new LoginAttemp($username, $password);
			$this->eventDispatcher->notify($loginAttempt);

			// do more stuff
		}
	}

	$loginChecker = new LoginChecker();
	$loginChecker->addObserver($eventDispatcher);


## Advantages and disadvantages

One advantage is that your plugin api is simple and the events are easy to document. If
you choose to put all your events in one directory all your api is in one place and
easy to inspect.

Another advantage is that you can start using plugins right away by using the trait
`ObserverStore` and throw an event. It is very simple to implement.

A third advantage is that loading plugins is simple by adding them to the
`EventDispatcher`.

A disadvantage of this approach is that the `EventDispatcher` needs to be added as an
observer to every class that is observable or passed as a constructor dependency.
That is why I prefer to use it together with [Fjor](http://koenhoeymans.github.com/Fjor/index.html).
While Fjor creates the objectgraph it can be told to add the `EventDispatcher`
instance to every instance of a class that implements `Observable` or upon construction.
This means that you actually don't have to do any work in adding the `EventDispatcher`
and can forget about it while Fjor does the work for you.
