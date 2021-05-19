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

    /**
     * @var Event
     */
    protected $event;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->init();
    }

    protected function init()
    {
        $this->jwt = new Jwt($this);

        $this->initEvent();
    }

    protected function initEvent()
    {
        // $this->config->getEventHandler()
        var_dump($this->config->getEventHandler());
        $this->event = new Event($this->config->getEventHandler());
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
        $token = $this->jwt->make($id, $cliams);

        $this->event->login($token);

        return $token;
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

    /**
     * 获取验证后的Token对象
     * @return Token
     */
    public function getVerifyToken()
    {
        return $this->jwt->getVerifyToken();
    }
}
