EPA
===


What is it?
-----------

EPA stands for Event-based Plugin Architecture. These are some simple classes
that together form a whole that can be used to let plugins enhance your
code. The plugins can register themselves for certain events and are
notified of and passed the event when it occures.


Using it
--------

Let's say you want to rapidly enhance your classes and give the opportunity to
allow plugins.

Let's first look at what an event is. Actually an event can be just about everything you
want it to be. It just needs to implement `Epa\Event` but has no defined methods. This
can be an event:

	use Epa\Event;

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
allow a plugin to change something:

	use Epa\Event;

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

For each class that you allow a plugin to change something you use
the interface `Epa\Observable` and the train `Epa\Pluggable` to implement it.

	use Epa\Observable;
	use Epa\Pluggable;

	class MyClass implements Observable
	{
		use Pluggable;
	}

Anytime your class has something interesting for plugins you can 'throw' an event.

	use Epa\Observable;
	use Epa\Pluggable;

	class BlogPostDisplay implements Observable
	{
		use Pluggable;

		public function display($postContent)
		{
			// ...
			$this->notify(new BeforePublishPostEvent($postContent));
			// ...
		}
	}

Now all plugins that are interested in this event will be notified and be able to do
something with the post content.

Plugins implement the interface `Epa\Plugin`:

	use Epa\Plugin;

	class FailedLoginLogger implements Plugin
	{
		public function register(EventMapper $mapper)
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

The event names are the class names of the event that is thrown by the
observable/pluggable classes.


Advantages and disadvantages
----------------------------

One advantage is that your plugin api is simple and the events are easy to document. If
you choose to put all your events in one directory all your api is in one place and
easy to inspect.

Another advantage is that you can start using plugins right away by using the trait
`Observable` and throw an event. It is very simple to implement.

A third advantage is that loading plugins is simply adding them to the `EventDispatcher`.

A disadvantage of this approach is that the `EventDispatcher` needs to be added as an
observer to every class that is observable. That is why I prefer to use it together with
[Fjor](http://koenhoeymans.github.com/Fjor/index.html). While Fjor creates the object
graph it can be told to add the `EventDispatcher` instance to every instance of a
class that implements `Observable`. This means that you actually don't have to do any
work in adding the `EventDispatcher` and can forget about it while Fjor does the work
for you.