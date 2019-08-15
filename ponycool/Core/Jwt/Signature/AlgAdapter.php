<?php

namespace PonyCool\Core\Jwt\Signature;

use PonyCool\Core\Jwt\Json\Json;
use PonyCool\Core\Jwt\Base64\Base64Url;

class AlgAdapter implements AlgInterface
{
    protected $alg;
    protected $secret;
    protected $header;
    protected $payload;

    /**
     * @return mixed
     */
    public function getAlg()
    {
        return $this->alg;
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


    public function __construct($alg)
    {
        $this->setAlg($alg);
    }

    /**
     * 初始化算法适配器
     * @param string $secret
     * @param array $header
     * @param array $payload
     */
    public function init(string $secret, array $header, array $payload): void
    {
        $this->setSecret($secret);
        $this->setHeader(Base64Url::base64UrlEncode(Json::jsonEncode($header)));
        $this->setPayload(Base64Url::base64UrlEncode(Json::jsonEncode($payload)));
    }

    /**
     * 加密
     * @return string
     */
    public function encrypt(): string
    {
        $alg = $this->getAlg();
        $raw = [
            $this->getHeader(),
            $this->getPayload()
        ];
        $raw = implode(".", $raw);
        $signature = $alg->encrypt($this->getSecret(), $raw);
        $signature = Base64Url::base64UrlEncode($signature);
        return $signature;
    }

    public function decrypt(): array
    {
        return [];
        // TODO: Implement decrypt() method.
    }

}