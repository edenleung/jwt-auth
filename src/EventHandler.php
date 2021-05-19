<?php

namespace JwtAuth;

use Lcobucci\JWT\Token;

interface EventHandler
{
    public function login(Token $token);
}
