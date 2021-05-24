<?php

namespace JwtAuth;

use think\User\AuthorizationUserInterface;

class User
{
    /**
     * @var AuthorizationUserInterface
     */
    protected $model;

    public function __construct($model)
    {
        $class = new $model;
        if ($class instanceof AuthorizationUserInterface) {
            $this->model = $class;
        } else {
            throw new \Exception('must be implements \think\User\AuthorizationUserInterface');
        }
    }

    /**
     * 获取登录用户对象
     * 
     * @param Jwt $jwt
     * @return AuthorizationUserInterface
     */
    public function get(Jwt $jwt)
    {
        $token = $jwt->getVerifyToken();
        $identifier = $token->claims()->get('jti');

        return $this->model->getUserById($identifier);
    }
}
