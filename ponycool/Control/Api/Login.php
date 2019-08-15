<?php
declare(strict_types=1);

namespace PonyCool\Control\Api;

use PonyCool\Service\LoginService;
use PonyCool\Library\Code;

class Login extends BaseController
{
    /**
     * 认证授权
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function Authentication()
    {
        $accountName = $this->request->getGet('account_name');
        $pwd = $this->request->getGet('pwd');
        $data = [
            'code' => Code::FAIL(),
            'message' => '登陆失败'
        ];
        if (is_string($accountName) && is_string($pwd)) {
            $loginService = new LoginService();
            $res = $loginService->login($accountName, $pwd);
            if (!empty($res)) {
                $data = [
                    'code' => Code::SUCCESS(),
                    'messsage' => '登陆成功',
                    'token' => $res
                ];
            }
        }
        return $this->render($data);
    }
}