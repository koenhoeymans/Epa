<?php

namespace Epa\Api;

/**
 * An event is what is passed to observers.
 * If the event is passed to
 * the `\Epa\Api\EventDispatcher` (also an observer) it passes the event to the
 * callbacks that are subscribed to the event.
 */
interface Event
{}
