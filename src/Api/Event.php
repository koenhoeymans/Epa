<?php

namespace Epa\Api;

/**
 * An event is an object that is passed to observers when the event is called.
 * If the event is passed to the `\Epa\Api\EventDispatcher` (which is also an
 * observer) it passes the event to the callbacks that are subscribed for the
 * event.
 *
 * Example use:
 *
 *     class \NewMessage implements \Epa\Api\Event
 *     {
 *         private $message;
 *
 *         public function __construct(string $message)
 *         {
 *             $this->message = $message;
 *         }
 *
 *         public function getMessage() : string
 *         {
 *             return $this->message;
 *         }
 *     }
 *
 *     class \LazyLogger {
 *
 *         private $log = '';
 *
 *         public function log(string $message) : void
 *         {
 *             $this->log = $message;
 *         }
 *     }
 *
 *     class \MessagingApp
 *     {
 *         private $eventDispatcher;
 *
 *         private $logger;
 *
 *         public function __construct(\Epa\EventDispatcher $eventDispatcher)
 *         {
 *             private $eventDispatcher;
 *         }
 *
 *         public function acceptMessage(string $message) : void
 *         {
 *             $newMessageEvent = new \NewMessage($message);
 *             $this->eventDispatcher->notify($newMessageEvent);
 *         }
 *     }
 *
 *     $lazyLogger = new \LazyLogger();
 *     $eventDispatcher = \Epa\EventDispatcherFactory::create();
 *     $eventDispatcher->registerForEvent('\\NewMessage', $lazyLogger);
 *     $messagingApp = new \MessagingApp($eventDispatcher);
 *     $messagingApp->acceptMessage('Hello world!');
 *
 *     $this->assertEquals('Hello world!', $lazyLogger->getMessage());
 */
interface Event
{
}
