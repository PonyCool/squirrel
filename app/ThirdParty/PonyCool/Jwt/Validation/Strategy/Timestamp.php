<?php


namespace PonyCool\Jwt\Validation\Strategy;

/**
 * 时间戳验证策略
 * Class Timestamp
 * @package PonyCool\Jwt\Validation\Strategy
 */
class Timestamp implements StrategyInterface
{
    public function validator(string $param): bool
    {
        if (!(int)$param) {
            return false;
        }
        if ((string)strtotime(date('Y-m-d H:i:s', (int)$param)) === $param) {
            return $param;
        } else {
            return false;
        }
    }
}