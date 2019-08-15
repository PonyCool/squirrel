<?php
declare(strict_types=1);

namespace PonyCool\Control\Api;

use PonyCool\Core\Jwt\Jwt;

class Account extends BaseController
{
    protected $helpers = ['cookie'];

    public function create()
    {
        $token = $this->request->getCookie('token');
        $jwt = new Jwt();
        $secret = getenv('app.jwt.secret');
        $verifyResult = $jwt->verify($secret, $token);
        //todo
        //验证是否是超级管理员，账号ID为超级管理员
        //创建用户
    }
}