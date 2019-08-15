<?php


namespace PonyCool\Core\Jwt\Validation;


abstract class Strategy
{
    // 策略
    protected $strategy;
    // 验证策略
    protected $validationStrategy;

    abstract public function validator(string $param): bool;
}