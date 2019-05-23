<?php


namespace PonyCool\Jwt\Validation\Strategy;


interface StrategyInterface
{
    public function validator(string $param): bool;
}