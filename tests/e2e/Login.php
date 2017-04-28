<?php

namespace Epa;

class Login implements \Epa\Api\Observable
{
    use \Epa\Api\ObserverStore;

    private $username = 'bar';

    private $pass = 'baz';

    public function login($name, $pass): void
    {
        /**
         * do stuff
         */
        $success = ($this->username === $name && $this->pass === $pass);
        $this->notify(new \Epa\LoginEvent($name, $pass, $success));
    }
}
