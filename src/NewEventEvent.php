<?php

namespace Epa;

class NewEventEvent implements \Epa\Api\NewEventEvent
{
    private $names;

    public function __construct(array $names)
    {
        $this->names = $names;
    }

    /**
     * @see \Epa\Api\NewEventEvent::getEventNames()
     */
    public function getEventNames(): array
    {
        return $this->names;
    }

    /**
     * @see \Epa\Api\NewEventEvent::addName()
     */
    public function addName(string $name): void
    {
        $this->names[] = $name;
    }

    /**
     * @see \Epa\Api\NewEventEvent::removeName()
     */
    public function removeName(string $name): void
    {
        $key = array_search($name, $this->names);

        if ($key !== false) {
            unset($this->names[$key]);
        }
    }
}
