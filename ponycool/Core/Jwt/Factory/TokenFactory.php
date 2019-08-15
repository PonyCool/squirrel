<?php


namespace PonyCool\Core\Jwt\Factory;


abstract class TokenFactory
{
    abstract public function createToken();
}