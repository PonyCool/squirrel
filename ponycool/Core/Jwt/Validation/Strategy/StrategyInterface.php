<?php


namespace PonyCool\Core\Jwt\Validation\Strategy;


interface StrategyInterface
{
    public function validator(string $param): bool;
}