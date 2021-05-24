<?php

use JwtAuth\Config;
use JwtAuth\JwtAuth;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/EventHandler.php';

$options = [
    'signer_key'    => 'oP0qmqzHS4Vvml5a',
    'public_key'    => 'file://path/public.key',
    'private_key'   => 'file://path/private.key',
    'not_before'    => 0,
    'expires_at'    => 3600,
    'refresh_ttL'   => 7200,
    'signer'        => 'Lcobucci\JWT\Signer\Hmac\Sha256',
    'type'          => 'Header',
    'relogin_code'  => 50001,
    'refresh_code'  => 50002,
    'iss'           => 'client.tant',
    'aud'           => 'server.tant',
    'event_handler' => EventHandler::class,
    'user_model'    => \app\common\model\User::class
];

// $manger = new Manager([
//     'sso' => true,
// ]);
$auth = new JwtAuth(new Config($options));

$id = 1;
$token = $auth->token($id, ['time' => time()])->toString();
// var_dump($auth->parseToken($token));
