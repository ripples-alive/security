<?php
/**
 * Created by PhpStorm.
 * User: Jayvic
 * Date: 14/12/14
 * Time: 下午11:06
 */

namespace Security\Controllers;

use Auth;
use BaseController;
use View;

class FunctionController extends BaseController {

    public static function dashboard() {
        return View::make('dashboard', array('user' => Auth::user()));
    }

    public static function show() {
        return View::make('show');
    }

} 