<?php

namespace PonyCool\Jwt\Token;

use DateTime;
use PonyCool\Jwt\Json\Json;
use PonyCool\Jwt\Signature\Signature;
use PonyCool\Jwt\Base64\Base64Url;
use PonyCool\Jwt\Validation\ValidationStrategy;
use PonyCool\Jwt\Exception\{TokenException,
    ValueException,
    ExpiredException,
    ArgumentException,
    SignatureException,
    MethodCallException,
    BeforeValidException};

class JwtToken extends Token
{
    /**
     * @return mixed
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param mixed $secret
     */
    public function setSecret($secret): void
    {
        $this->secret = $secret;
    }

    /**
     * @return mixed
     */
    public function getAlg()
    {

        return $this->alg ?? 'HS256';
    }

    /**
     * @param mixed $alg
     */
    public function setAlg($alg): void
    {
        $this->alg = $alg;
    }

    /**
     * @return mixed
     */
    public function getTyp()
    {
        return $this->typ ?? 'JWT';
    }

    /**
     * @param mixed $typ
     */
    public function setTyp($typ): void
    {
        $this->typ = $typ;
    }


    /**
     * @return mixed
     */
    public function getIss()
    {
        $issuer = 'PonyCool';
        return $this->iss ?? $issuer;
    }

    /**
     * @param mixed $iss
     */
    public function setIss($iss): void
    {
        $this->iss = $iss;
    }

    /**
     * 过期时间，默认为签发时间+2小时
     * @return mixed
     */
    public function getExp()
    {
        $timestamp = $this->exp ?? strtotime("+2 hours");
        return $timestamp;
    }

    /**
     * @param mixed $exp
     */
    public function setExp($exp): void
    {
        $this->exp = $exp;
    }

    /**
     * @return mixed
     */
    public function getSub()
    {
        $subject = 'authenticate';
        return $this->sub ?? $subject;
    }

    /**
     * @param mixed $sub
     */
    public function setSub($sub): void
    {
        $this->sub = $sub;
    }

    /**
     * @return mixed
     */
    public function getAud()
    {
        $audience = 'user';
        return $this->aud ?? $audience;
    }

    /**
     * @param mixed $aud
     */
    public function setAud($aud): void
    {
        $this->aud = $aud;
    }

    /**
     * @return mixed
     */
    public function getNbf()
    {
        $timestamp = $this->nbf ?? time();
        return $timestamp;
    }

    /**
     * @param mixed $nbf
     */
    public function setNbf($nbf): void
    {
        $this->nbf = $nbf;
    }

    /**
     * @return mixed
     */
    public function getIat()
    {
        $timestamp = $this->iat ?? time();
        return $timestamp;
    }

    /**
     * @param mixed $iat
     */
    public function setIat($iat): void
    {
        $this->iat = $iat;
    }

    /**
     * @return mixed
     */
    public function getJti()
    {
        return $this->jti;
    }

    /**
     * @param mixed $jti
     */
    public function setJti($jti): void
    {
        $this->jti = $jti;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param mixed $uid
     */
    public function setUid($uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @return mixed
     */
    public function getAdmin()
    {
        return $this->admin ?? 'false';
    }

    /**
     * @param mixed $admin
     */
    public function setAdmin($admin): void
    {
        $this->admin = $admin;
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param mixed $header
     */
    public function setHeader($header): void
    {
        $this->header = $header;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param mixed $payload
     */
    public function setPayload($payload): void
    {
        $this->payload = $payload;
    }

    /**
     * @return mixed
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param mixed $signature
     */
    public function setSignature($signature): void
    {
        $this->signature = $signature;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }


    /**
     * 获取Token
     * @return string
     */
    public function get(): string
    {
        $header = [
            'alg' => $this->getAlg(),
            'typ' => $this->getTyp(),
        ];
        $this->setHeader($header);
        $payload = [
            'iss' => $this->getIss(),
            'exp' => $this->getExp(),
            'sub' => $this->getSub(),
            'name' => $this->getName(),
            'uid' => $this->getUid(),
            'admin' => $this->getAdmin(),
            'aud' => $this->getAud(),
            'nbf' => $this->getNbf(),
            'iat' => $this->getIat(),
            'jti' => $this->getJti(),
        ];
        $this->setPayload($payload);
        $signatureObj = new Signature();
        $signature = $signatureObj->generate($this->getSecret(), $this->getHeader(), $this->getPayload());
        $tokenArr = [
            Base64Url::base64UrlEncode(Json::jsonEncode($this->getHeader())),
            Base64Url::base64UrlEncode(Json::jsonEncode($this->getPayload())),
            $signature
        ];
        $token = implode(".", $tokenArr);
        return $token;
    }

    /**
     * TOKEN 验证
     * @param string $secret
     * @param string $token
     * @return bool
     * @throws \ReflectionException
     */
    public function verify(string $secret, string $token): bool
    {
        if (empty($secret)) {
            throw new ArgumentException("密钥无效");
        }
        $this->setSecret($secret);
        $token = explode(".", $token);
        if (3 !== count($token)) {
            throw new TokenException("不合法的TOKEN");
        }
        $header = Json::jsonDecode(Base64Url::base64UrlDecode($token[0]));
        $payload = Json::jsonDecode(Base64Url::base64UrlDecode($token[1]));
        if (is_null($header)) {
            throw new ValueException("头部解码失败");
        }
        if (is_null($payload)) {
            throw new ValueException("有效负载解码失败");
        }
        $rawSignature = Base64Url::base64UrlDecode($token[2]);
        if (false === $rawSignature) {
            throw new ValueException("签名解码失败");
        }
        if (empty($header['alg'])) {
            throw new ValueException("签名算法错误");
        }
        if (empty($header['typ']) || 'JWT' !== $header['typ']) {
            throw new ValueException("令牌类型错误");
        }
        $this->setAlg($header['alg']);
        $this->setTyp($header['typ']);
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
            $method = 'set' . ucfirst(strtolower($k));
            if (!method_exists($this, $method)) {
                throw new MethodCallException("JWT有效负载存在无效的属性");
            }
            $this->$method($v);
        }
        $timestamp = time();
        // 生效时间之前不接收处理该token
        if ($this->getNbf() > $timestamp) {
            throw new BeforeValidException(
                date(DateTime::ISO8601, $this->getNbf()) . "之前无法处理令牌"
            );
        }
        // 签发时间大于当前服务器时间验证失败
        if ($this->getIat() > $timestamp) {
            throw new BeforeValidException(
                date(DateTime::ISO8601, $this->getIat()) . "之前无法处理令牌"
            );
        }
        // 过期时间小于、等于当前服务器时间验证失败
        if ($timestamp >= $this->getExp()) {
            throw new ExpiredException("令牌过期");
        }
        $this->setHeader($header);
        $this->setPayload($payload);
        // 验证签名
        $rawSignature = Base64Url::base64UrlEncode($rawSignature);
        $signatureObj = new Signature();
        $res = $signatureObj->verify($this->getSecret(), $this->getHeader(), $this->getPayload(), $rawSignature);
        if (!$res) {
            throw new SignatureException("签名验证失败");
        }
        return true;
    }
}