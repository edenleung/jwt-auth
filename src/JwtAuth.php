<?php

namespace JwtAuth;

use Lcobucci\JWT\Token;
use think\User\AuthorizationUserInterface;
use JwtAuth\Exception\InvalidArgumentException;

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

    /**
     * @var User
     */
    protected $user;

    public function __construct(Config $config, EventHandler $event = null)
    {
        $this->config = $config;
        $this->event = $event;
        $this->init();
    }

    protected function init()
    {
        $this->jwt = new Jwt($this);

        $this->initUser();
    }

    protected function initUser()
    {
        if ($model = $this->config->getUserModel()) {
            $this->user = new User($model);
        }
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
        $flag = $this->jwt->validate($token);
        $this->event->verify($this->parseToken($token));
        return $flag;
    }

    /**
     * 解析 Token
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

    /**
     * 获取登录用户对象
     *
     * @return AuthorizationUserInterface|null
     */
    public function getUser()
    {
        if ($this->user) {
            return $this->user->get($this->jwt);
        }

        throw new InvalidArgumentException('jwt.user_model required');
    }
}
