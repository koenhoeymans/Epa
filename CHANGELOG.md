Epa Changelog
=============

0.2.3

	* Plugin allows that eventnames can also be specified in the PHPDoc
	  of all extended classes (`Epa\MetaEventNamePlugin`). Removed `@event`
	  so only `@eventname` needs to be used. If no name is specified it uses
	  the class name.

0.2.2

	* Added a plugin that looks at the doc comments of interfaces that are implemented
	  by an event. `@event` and `@eventName` allow to add custom event names.

0.2.1

	* EventDispatcher throws event `NewEventEvent` when notified of new event.

0.2.0

	* `Plugin` is now an interface instead of an abstract class.

0.1.0

	* Initial release.