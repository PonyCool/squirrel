<?php


namespace PonyCool\Core\Jwt;

use ReflectionMethod;
use PonyCool\Core\Jwt\Factory\JwtTokenFactory;
use PonyCool\Core\Jwt\Validation\ValidationStrategy;
use ReflectionException;
use PonyCool\Core\Jwt\Exception\{TokenException,
    ValueException
};

class Jwt
{

    /**
     * 获取Token
     * @param string $secret
     * @param array|null $header
     * @param array|null $payload
     * @return string
     * @throws ReflectionException
     */
    public function getToken(string $secret, array $header = null, array $payload = null): string
    {
        $factory = new JwtTokenFactory();
        $token = $factory->createToken();
        // 设置密钥
        $token->setSecret($secret);
        // 设置头部
        if (!is_null($header)) {
            if (!isset($header['alg'])) {
                throw new ValueException("未设置签名算法");
            }
            if (!isset($header['typ']) || $header['typ'] !== 'JWT') {
                throw new ValueException("令牌类型错误");
            }
            $token->setAlg($header['alg']);
            $token->setTyp($header['typ']);
        }
        // 设置有效负载
        if (!is_null($payload)) {
            $validation = new ValidationStrategy();
            $validation->setStrategy('timestamp');
            $timestampArr = [
                'exp' => '过期时间',
                'nbf' => '生效时间',
                'iat' => '签发时间',
            ];
            foreach ($payload as $k => $v) {
                if (key_exists($k, $timestampArr)) {
                    $res = $validation->validator($v);
                    if (!$res) {
                        throw new ValueException($timestampArr[$k] . "时间格式错误");
                    }
                }
                if ($k === 'admin') {
                    if (!in_array($v, ['true', 'false'], true)) {
                        throw new ValueException("Admin类型错误");
                    }
                }
                try {
                    $method = new ReflectionMethod(get_class($token), 'set' . ucfirst(strtolower($k)));
                    $method->invoke($token, $v);
                } catch (ReflectionException $exception) {
                    throw new ReflectionException("JWT有效负载存在无效的属性");
                }
            }
        }
        return $token->get();
    }

    /**
     * 验证JWT
     * @param string $secret
     * @param string $t
     * @return bool
     * @throws ReflectionException
     */
    public function verify(string $secret, string $t): bool
    {
        $factory = new JwtTokenFactory();
        $token = $factory->createToken();
        try {
            $res = $token->verify($secret, $t);
            return $res;
        } catch (TokenException $exception) {
            return false;
        }
    }
}