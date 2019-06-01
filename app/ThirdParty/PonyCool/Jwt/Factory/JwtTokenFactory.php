<?php


namespace PonyCool\Jwt\Factory;

use PonyCool\Jwt\Token\JwtToken;

class JwtTokenFactory extends TokenFactory
{
    public function createToken()
    {
        return new JwtToken();
    }
}