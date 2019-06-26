<?php
declare(strict_types=1);

namespace PonyCool\Libraries;

use MyCLabs\Enum\Enum;

class Code extends Enum
{
    // 成功
    private const SUCCESS = 0;
    // 通用错误
    private const FAIL = 1;
    // 资源未找到
    private const NOT_FOUND = 2;
    // 未授权
    private const UNAUTHORIZED = 3;

    public static function SUCCESS()
    {
        return new Code(self::SUCCESS);
    }

    public static function FAIL()
    {
        return new Code(self::FAIL);
    }

    public static function NOT_FOUND()
    {
        return new Code(self::NOT_FOUND);
    }

    public static function UNAUTHORIZED()
    {
        return new Code(self::UNAUTHORIZED);
    }
}