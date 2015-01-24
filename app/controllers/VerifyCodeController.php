<?php
/**
 * Created by PhpStorm.
 * User: Jayvic
 * Date: 14/12/15
 * Time: 下午2:53
 */

namespace Security\Controllers;

use BaseController;
use Response;

use Security\Helpers\VerifyCodeHelper;

class VerifyCodeController extends BaseController {

    public static function getCode() {
        return Response::make(VerifyCodeHelper::generateVerifyCodeImage())->header('Content-Type', 'image/png');
    }

} 