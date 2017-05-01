<?php

namespace Epa;

class EventNameChangerPlugin implements \Epa\Api\Plugin
{
    public function registerHandlers(\Epa\Api\EventDispatcher $mapper): void
    {
        $mapper->registerForEvent(
            'Epa\\Api\\NewEventEvent',
            function (\Epa\Api\NewEventEvent $event) {
                $this->handleEvent($event);
            }
        );
    }

    private function handleEvent(\Epa\Api\NewEventEvent $event): void
    {
        $names = $event->getEventNames();
        foreach ($names as $name) {
            $newName = substr(strrchr($name, '\\'), 1);
            $event->addName($newName);
        }
    }
}
