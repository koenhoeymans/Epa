<?php

namespace Epa;

class ClassWithEvent
{
    use \Epa\Api\ObserverStore;

    public function createEvent(\Epa\Api\Event $event)
    {
        $this->notify($event);
    }
}
