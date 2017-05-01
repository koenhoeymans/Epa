<?php

namespace Epa;

class LoginEvent implements \Epa\Api\Event
{
    private $name;

    private $pass;

    private $succeeded;

    public function __construct($name, $pass, $succeeded)
    {
        $this->name = $name;
        $this->pass = $pass;
        $this->succeeded = $succeeded;
    }

    public function loginSucceeded(): bool
    {
        return (bool) $this->succeeded;
    }

    public function loginFailed(): bool
    {
        return !$this->loginSucceeded();
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPass()
    {
        return $this->pass;
    }
}
