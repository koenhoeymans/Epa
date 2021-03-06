<?php

namespace Epa;

class LoginEventLogger implements \Epa\Api\Plugin
{
    private $name = 'LoginEvent';

    private $pass = 'NotCalled';

    public function registerHandlers(\Epa\Api\EventDispatcher $mapper): void
    {
        $mapper->registerForEvent('LoginEvent', function (LoginEvent $event) {
            $this->handleLogin($event);
        });
    }

    private function handleLogin(LoginEvent $event): void
    {
        $this->name = $event->getName();
        $this->pass = $event->getPass();
    }
    public function getLastLogin(): string
    {
        return 'last login was ' . $this->name . ':' . $this->pass;
    }
}
