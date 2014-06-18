<?php

namespace Epa;

class LoginNameChanger implements \Epa\Api\Plugin
{
    public function registerHandlers(\Epa\Api\EventDispatcher $dispatcher)
    {
        $dispatcher->registerForEvent(
            'LoginEvent',
            function (LoginEvent $event) {
                $this->handleLogin($event);
            }
        )->first();
    }
    private function handleLogin(LoginEvent $event)
    {
        $event->setName('baz');
    }
}
