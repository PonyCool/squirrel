<?php
declare(strict_types=1);

namespace PonyCool\Services;

use PonyCool\Core\Jwt\Jwt;
use PonyCool\Models\AccountModel;
use Exception;

class LoginService extends BaseService
{
    /**
     * 登陆
     * @param string $account_name 账户名称
     * @param string $pwd 密码
     * @return string
     */
    public function login(string $account_name, string $pwd): string
    {
        $token = '';
        $db = $this->getDb();
        $accountModel = new AccountModel($db);
        $account = $accountModel->where('account_name', $account_name)
            ->first();
        if (!is_null($account)) {
            $encryPwd = hash_hmac('sha256', $pwd, $account->salt);
            if ($account->pwd === $encryPwd) {
                $secret = getenv('jwt.secret');
                try {
                    $jwt = new Jwt();
                    $token = $jwt->getToken(
                        $secret,
                        [
                            'typ' => 'JWT',
                            'alg' => 'HS256'
                        ],
                        [
                            'iss' => 'www.ponycool.com',
                            'sub' => 'login',
                            'aud' => 'www.ponycool.com',
                            'name' => $account->account_name,
                            'aid' => 0,
                            'gid' => 0,
                            'uid' => $account->id,
                            'admin' => (1 === $account->id) ? 'true' : 'false',
                        ]
                    );
                } catch (Exception $exception) {
                    var_dump($exception);
                }
            }
        }
        return $token;
    }
}