<?php

namespace PonyCool\Jwt\Token;
abstract class Token
{
    // 密钥
    public $secret;
    // 签名算法
    public $alg;
    // 令牌类型
    public $typ;
    // issuer 签发人
    public $iss;
    // expiration time 过期时间
    public $exp;
    // subject 主题
    public $sub;
    // audience 受众
    public $aud;
    // Not Before 生效时间
    public $nbf;
    // Issued At 签发时间
    public $iat;
    // JWT ID 编号
    public $jti;
    // 用户名
    public $name;
    // 用户UID
    public $uid;
    // 管理用户
    public $admin;
    // 头部
    public $header;
    // 有效负载
    public $payload;
    // 签名
    public $signature;
    // token
    public $token;

    abstract public function get(): string;

    abstract public function verify(string $secret, string $token): bool;
}