<?php


namespace PonyCool\Core\Jwt\Factory;

use PonyCool\Core\Jwt\Token\JwtToken;

class JwtTokenFactory extends TokenFactory
{
    public function createToken()
    {
        return new JwtToken();
    }
}