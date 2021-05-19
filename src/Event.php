<?php

namespace JwtAuth;

use Exception;
use JwtAuth\EventHandler;

class Event
{
    /**
     * @var Manger
     */
    protected $handle;

    public function __construct($handle = null)
    {
        if ($handle) {
            $class = new $handle;
            if ($class instanceof EventHandler) {
                $this->handle = $class;
            } else {
                throw new Exception('must be implements \JwtAuth\EventHandler');
            }
        }
    }

    public function __call($name, $arguments)
    {
        if ($this->handle) {
            call_user_func_array([$this->handle, $name], $arguments);
        }
    }
}
