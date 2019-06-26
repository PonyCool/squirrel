<?php
declare(strict_types=1);

namespace PonyCool\Libraries;

use MyCLabs\Enum\Enum;

class Code extends Enum
{
    private const TEST = '1';
    private const VIEW = 'view';
    private const EDIT = 'edit';
    const DEMO='1';
//    public static function VIEW() {
//        return new Code(self::VIEW);
//    }
}