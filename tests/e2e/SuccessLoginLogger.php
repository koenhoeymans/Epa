<?php

namespace Epa;

class SuccessLoginLogger implements \Epa\Api\Plugin
{
    private $log = '';

    public function registerHandlers(\Epa\Api\EventDispatcher $mapper)
    {
        $mapper->registerForEvent(
            'Epa\\LoginEvent',
            $this->handleSuccessLogin()
        );
    }

    private function handleSuccessLogin()
    {
        return function (\Epa\LoginEvent $event) {
            if (! $event->loginSucceeded()) {
                return;
            }
            $this->log = 'success for '
                . $event->getName()
                . ':'
                . $event->getPass();
        };
    }

    public function getLog()
    {
        return $this->log;
    }
}
