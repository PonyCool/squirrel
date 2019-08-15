<?php
declare(strict_types=1);

namespace PonyCool\Library;


class SaltLib
{
    /**
     * 生成指定长度、类型的盐值
     * @param int $len 长度
     * @param array $type 类型：1数字，2小写字母，3大写字母，4符号
     * @return string 盐值
     */
    public static function generate(int $len = 32, array $type = [1, 2, 3, 4]): string
    {
        $salt = '';
        $dec = [
            1 => [48, 57],
            2 => [97, 122],
            3 => [65, 90],
            4 => [[33, 47], [58, 64], [91, 96], [123, 126]]
        ];
        if (!empty($type)) {
            $mergerDec = array_intersect_key($dec, array_flip($type));
            $dec = empty($mergerDec) ? $dec : $mergerDec;
        }
        $dec = array_values($dec);
        for ($i = 0; $i < $len; $i++) {
            $randomDigit = mt_rand(0, count($dec) - 1);
            $randomRange = $dec[$randomDigit];
            if (3 === $randomDigit) {
                $randomRange = $dec[3][mt_rand(0, count($dec[3]) - 1)];
            }
            $salt .= chr(mt_rand($randomRange[0], $randomRange[1]));
        }
        return $salt;
    }
}