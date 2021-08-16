# jwt-auth

## install

### 开发版
```bash

composer require xiaodi/jwt-auth:dev-master

```

### 正式包
```bash

composer require xiaodi/jwt-auth

```
## example

```php

<?php

use JwtAuth\Config;
use JwtAuth\JwtAuth;

$options = [
    'signer_key'    => 'oP0qmqzHS4Vvml5a',
    'public_key'    => 'file://path/public.key',
    'private_key'   => 'file://path/private.key',
    'not_before'    => 0,
    'signer'        => 'Lcobucci\JWT\Signer\Hmac\Sha256',
    'type'          => 'Header',
    'relogin_code'  => 50001,
    'refresh_code'  => 50002,
    'iss'           => 'client.tant',
    'aud'           => 'server.tant',
    'event_handler' => Event::class,
    'user_model'    => \app\common\model\User::class
];

$auth = new JwtAuth(new Config($options));

// 用户 id
$id = 1;
// 附带参数
$cliasm = [];
$token = $auth->token($id, $cliams)->toString();

// 生成 token
var_dump($token);

// 验证 token
var_dump($auth->verify($token));

// 验证后 token 对象
var_dump($auth->getVerifyToken());

// 验证获取 id
var_dump($auth->getVerifyToken()->claims()->get('jti'));

// 解析 token
var_dump($auth->parseToken($token));

// 获取效验后的用户模型对象
var_dump($auth->getUser());
```

# TODO
- [ ] phpunit
- [x] manger event handler (login、verify、logout)
- [ ] exceptions
