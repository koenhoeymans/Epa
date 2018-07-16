# Epa Changelog

## [Unreleased]

### Changed

- Tests adjusted to work with PHPUnit 7.*
- Added return types and and type declarations new in PHP 7.0 and 7.1.
- Minimum PHP 7.2 required.
- Changelog format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/).


## [0.4.0] - 2014-12-16

	* Moved `EndToEndTests` and `UnitTests` to `tests`.
	* Renamed `Epa` folder to `src`.
	* Autoload using Composer PSR-4 autoloader.
	* Tests use PSR-4 namespacing.
	* Tests use phpunit xml file for configuration.
    * Formatting conform to PSR-2.
    * Added code coverage to phpunit xml configuration.

## older changes

0.3.0

	* Added public API.
	* Removed `@package` in docblocks.
	* Renaming of some classes, interfaces and methods.
	* Improved Doc Comments.
	* Events also have the name of all parent classes and interfaces.
	* Option to remove eventnames.
	* Moved `MetaEventNamePlugin` to own repo.

0.2.4

	* Plugins can add callbacks to the first position in the callback sequence.

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
