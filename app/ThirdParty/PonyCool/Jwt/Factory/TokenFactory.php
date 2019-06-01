<?php


namespace PonyCool\Jwt\Factory;


abstract class TokenFactory
{
    abstract public function createToken();
}