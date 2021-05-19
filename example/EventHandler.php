<?php

use Lcobucci\JWT\Token;

require_once __DIR__ . '/../vendor/autoload.php';

class EventHandler implements \JwtAuth\EventHandler
{
    public function login(Token $token)
    {
        // todo
    }
}
