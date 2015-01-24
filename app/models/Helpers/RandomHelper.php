<?php

namespace Security\Helpers;

class RandomHelper {

    /**
     * 生成一串随机的包含 0-9 的数字字符串。
     *
     * @param int $length 字符串的长度。
     *
     * @return string 生成的随机数字字符串。
     */
    public static function digits($length) {
        $result = '';
        while ($length--) {
            $result .= rand() % 10;
        }

        return $result;
    }

    /**
     * 生成一串随机的包含 0-9, a-z 的字符串。
     *
     * @param int $length 字符串的长度。
     *
     * @return string 生成的随机字符串。
     */
    public static function digitsAndLowercase($length) {
        $alphabet = '0123456789abcdefghijklmnopqrstuvwxyz';

        $result = '';
        while ($length--) {
            $result .= $alphabet[rand() % 36];
        }

        return $result;
    }

}
