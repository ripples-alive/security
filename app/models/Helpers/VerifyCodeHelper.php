<?php
/**
 * Created by PhpStorm.
 * User: Jayvic
 * Date: 14/12/15
 * Time: 下午2:34
 */

namespace Security\Helpers;

use Session;

/**
 * Class VerifyCodeHelper
 * @package Security\Helpers
 *
 * @author Qi Wen <qi.wen@frint.cn>
 */
class VerifyCodeHelper {

    public static function generateVerifyCodeImage() {
        $code = strtoupper(RandomHelper::digitsAndLowercase(4));
        Session::put('verify_code', $code);

        $width = 50;
        $height = 25;
        $im = imagecreate($width, $height);
        $back = imagecolorallocate($im, 0xFF, 0xFF, 0xFF);
        $pix = imagecolorallocate($im, 187, 230, 247);
        $font = imagecolorallocate($im, 41, 163, 238);
        mt_srand();
        for ($i = 0; $i < 1000; $i++) {
            imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), $pix);
        }
        imagestring($im, 5, 7, 5, $code, $font);
        imagerectangle($im, 0, 0, $width - 1, $height - 1, $font);
        imagerectangle($im, 0, 0, $width - 1, $height - 1, $font);
        imagerectangle($im, 0, 0, $width - 1, $height - 1, $font);
        imagepng($im);
        imagedestroy($im);

        return $code;
    }

    public static function verifyCode($code) {
        return Session::pull('verify_code') === strtoupper($code);
    }

}