<?php

namespace JwtAuth;

use Lcobucci\JWT\Token;

class JwtAuth
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Jwt
     */
    protected $jwt;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->init();
    }

    protected function init()
    {
        $this->jwt = new Jwt($this);
    }

    /**
     * 获取 Token 配置
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * 生成 Token
     * @param $id  唯一标识
     * @param $cliams 附带参数
     * 
     * @return Token
     */
    public function token($id, $cliams = [])
    {
        return $this->jwt->make($id, $cliams);
    }

    /**
     * 检测合法性
     * @return bool
     */
    public function verify($token)
    {
        return $this->jwt->validate($token);
    }

    /**
     * @param $token jwt token
     * @return Token
     */
    public function parseToken($token)
    {
        return $this->jwt->parseToken($token);
    }
}
