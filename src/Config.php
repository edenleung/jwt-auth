<?php

namespace JwtAuth;

use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Key\LocalFileReference;
use Lcobucci\JWT\Signer\Hmac;
use Lcobucci\JWT\Signer\Rsa;
use Lcobucci\JWT\Signer;
use JwtAuth\EventHandler;
use JwtAuth\Exception\InvalidArgumentException;

class Config
{
    /**
     * Hmac KEY
     * @var string
     */
    protected $signer_key = null;

    /**
     * 生成后 一定时间内不能使用
     * @var number
     */
    protected $not_before = 0;

    /**
     * Token 有效期
     * @var number
     */
    protected $expires_at = 3600;

    /**
     * Token 可刷新时长
     * @var number
     */
    protected $refresh_ttL = 7200;

    /**
     * Token 加密类型
     * @var string
     */
    protected $signer = \Lcobucci\JWT\Signer\Hmac\Sha256::class;

    /**
     * Token 获取途径
     * @var string
     */
    protected $type = 'Header';

    /**
     * Token 签发者
     * @var string
     */
    protected $iss = 'client.xiaodim.com';

    /**
     * Token 接收方
     * @var string
     */
    protected $aud = 'server.xiaodim.com';

    /**
     * Token 是否自动续签
     * @var bool
     */
    protected $automatic_renewal = false;

    /**
     * Token 用户模型
     * @var string
     */
    protected $user_model;

    /**
     * RSA 加密下公钥地址
     * @var string
     */
    protected $public_key = '';

    /**
     * RSA 加密下私钥地址
     * @var string
     */
    protected $private_key = '';

    /**
     * 事件回调
     * @var EventHandler
     */
    protected $event_handler;

    public function __construct(array $options)
    {
        foreach ($options as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * 获取 加密密钥
     *
     * @return \Lcobucci\JWT\Signer\Key\InMemory
     */
    public function getHmacKey(): Key
    {
        if (empty($this->signer_key)) {
            throw new InvalidArgumentException('config signer_key required.', 500);
        }

        return InMemory::base64Encoded((string)$this->signer_key);
    }

    /**
     * 获取 是否使用 RSA 加密
     *
     * @return bool
     */
    public function RSASigner()
    {
        $signer = $this->getSigner();

        return $signer instanceof Rsa;
    }

    /**
     * 获取 加密key
     *
     * @return Key
     */
    public function getSignerKey(): Key
    {
        $signer = $this->getSigner();

        if ($this->RSASigner()) {
            return $this->getPrivateKey();
        } else if ($signer instanceof Hmac) {
            return $this->getHmacKey();
        } else {
            throw new InvalidArgumentException('not support.', 500);
        }
    }

    /**
     * 获取 RSA 公钥
     *
     * @return Key
     */
    public function getPublicKey(): Key
    {
        return LocalFileReference::file($this->public_key);
    }

    /**
     * 获取 RSA 私钥
     *
     * @return Key
     */
    public function getPrivateKey(): Key
    {
        return LocalFileReference::file($this->private_key);
    }

    /**
     * 获取有效果期
     *
     * @return number
     */
    public function getExpires()
    {
        return $this->expires_at;
    }

    /**
     * 获取刷新ttl
     *
     * @return string
     */
    public function getRefreshTTL()
    {
        return $this->refresh_ttL;
    }

    /**
     * 获取iss
     *
     * @return string
     */
    public function getIss(): string
    {
        return $this->iss;
    }

    /**
     * 获取auid
     *
     * @return string
     */
    public function getAud(): string
    {
        return $this->aud;
    }

    /**
     * 获取not_before
     *
     * @return number
     */
    public function getNotBefore()
    {
        return $this->not_before;
    }

    /**
     * 获取加密对象
     *
     * @return Signer
     */
    public function getSigner(): Signer
    {
        return new $this->signer;
    }


    /**
     * 获取重新登录code
     *
     * @return number
     */
    public function getReloginCode()
    {
        return $this->relogin_code;
    }

    /**
     * 获取刷新code
     *
     * @return number
     */
    public function getRefreshCode()
    {
        return $this->refresh_code;
    }

    /**
     * 获取是否自动续签
     *
     * @return bool
     */
    public function getAutomaticRenewal()
    {
        return $this->automatic_renewal;
    }

    /**
     * 获取token途径
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * 获取事件
     *
     * @return string|null
     */
    public function getEventHandler()
    {
        return $this->event_handler ?: null;
    }

    /**
     * 获取用户模型
     *
     * @return string|null
     */
    public function getUserModel()
    {
        return $this->user_model;
    }
}
