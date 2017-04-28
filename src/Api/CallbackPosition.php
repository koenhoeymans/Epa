<?php

namespace Epa\Api;

/**
 * Part of the fluent interface when registering callbacks starting with
 * `registerForEvent`.
 * The position of the callback can be specified when
 * one needs to make sure a callback is e.g. called before other callbacks.
 */
interface CallbackPosition
{
    /**
     * Adds the callback first.
     * Note that it is possible that another callback
     * afterwards also asks to be called first. So one cannot have 100%
     * guarantee that it will really be called first when there are other
     * callbacks registering for the event.
     */
    public function first(): void;
}
