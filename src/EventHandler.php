<?php

namespace JwtAuth;

use Lcobucci\JWT\Token;

interface EventHandler
{
    /**
     * 登录事件
     * @param Token $token
     * @return void
     */
    public function login(Token $token);

    /**
     * 登出事件
     * @param Token $token
     * @return void
     */
    public function logout(Token $token);
}
