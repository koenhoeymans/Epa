<?php

namespace Epa;

class FailedLoginLogger implements \Epa\Api\Observer
{
    private $log;

    public function notify(\Epa\Api\Event $event): void
    {
        if (!($event instanceof \Epa\LoginEvent)) {
            return;
        }

        if (! $event->loginFailed()) {
            return;
        }

        $this->log = 'failure for '
            . $event->getName()
            . ':'
            . $event->getPass();
    }

    public function getLog()
    {
        return $this->log;
    }
}
