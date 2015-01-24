<?php
/**
 * Created by PhpStorm.
 * User: Jayvic
 * Date: 14/12/14
 * Time: 下午9:54
 */

namespace Security\Controllers;

use Auth;
use BaseController;
use Cache;
use DB;
use Input;
use Redirect;
use View;

use Security\Models\User;
use Security\Models\UserRoleRels;

use Security\Helpers\VerifyCodeHelper;

class UserController extends BaseController {

    public static function getLogin() {
        return View::make('login');
    }

    public static function postLogin() {
        $username = Input::get('username');
        $password = Input::get('password');
        $code = Input::get('code');

        if (empty($username)) {
            return View::make('login', array('info' => '请输入用户名！'));
        }

        if (empty($password)) {
            return View::make('login', array('info' => '请输入密码！'));
        }

        if (!VerifyCodeHelper::verifyCode($code)) {
            return View::make('login', array('info' => '验证码错误！'));
        }

        if (User::isUserFreezed($username)) {
            return View::make('login', array('info' => '用户已被锁定！'));
        }
        $cache_name = 'try_login?username=' . $username;
        if (Auth::attempt(array('username' => $username, 'password' => $password, 'freezed' => 0))) {
            return Redirect::to('dashboard');
        } else {
            $try_times = Cache::get($cache_name);
            if (empty($try_times)) {
                $try_times = 1;
            } else {
                $try_times += 1;
            }
            Cache::put($cache_name, $try_times, 3);
            if ($try_times == 3) {
                User::lockUserByName($username);
            }

            return View::make('login', array('info' => '用户名或密码错误！'));
        }
    }

    public static function logout() {
        Auth::logout();
        return Redirect::to('login');
    }

    public static function getAdd() {
        return View::make('user.add');
    }

    public static function postAdd() {
        $username = Input::get('username');
        $password = Input::get('password');
        $email = Input::get('email');
        $others = Input::except(array('username', 'password', 'email'));

        if (empty($username)) {
            return View::make('user.add', array('info' => '请输入用户名！'));
        }

        if (empty($password)) {
            return View::make('user.add', array('info' => '请输入密码！'));
        }

        if (!User::usernameAvailable($username)) {
            return View::make('user.add', array('info' => '用户名已存在！'));
        }

        $roles = array();
        foreach ($others as $key => $value) {
            if (substr($key, 0, 4) === 'role') {
                $roles[] = intval(substr($key, 4));
            }
        }

        return DB::transaction(function() use ($username, $password, $email, $roles) {
            $user_id = User::addUser($username, $password, $email);
            if (empty($user_id)) {
                return View::make('user.add', array('info' => '添加用户失败！'));
            }

            UserRoleRels::addRolesForUser($user_id, $roles);

            return View::make('user.add', array('info' => '添加用户成功！'));
        });

    }

    public static function getModify() {
        return View::make('user.modify');
    }

    public static function postModify() {
        $password = Input::get('password');
        $email = Input::get('email');
        $others = Input::except(array('password', 'email'));

        $roles = array();
        foreach ($others as $key => $value) {
            if (substr($key, 0, 4) === 'role') {
                $roles[] = intval(substr($key, 4));
            }
        }

        return DB::transaction(function() use ($password, $email, $roles) {
            if ((User::modifyUser(Auth::id(), $password, $email) <= 0) && (UserRoleRels::removeRolesForUser(Auth::id(), $roles) <= 0)) {
                return View::make('user.modify', array('info' => '修改用户信息失败！'));
            }

            return View::make('user.modify', array('info' => '修改用户信息成功！'));
        });
    }

    public static function getUnlock() {
        return View::make('user.unlock');
    }

    public static function postUnlock() {
        $user_id = intval(Input::get('user_id'));

        if (User::unlockUserById($user_id) <= 0) {
            return View::make('user.unlock', array('info' => '解锁用户失败！'));
        }

        return View::make('user.unlock', array('info' => '解锁用户成功！'));
    }

} 