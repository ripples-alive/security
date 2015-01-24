<?php

namespace Security\Models;

use Cache;
use DB;

use Exception;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

class User implements UserInterface {

	use UserTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

    public static function getAuthorityById($id) {
//        $cache_name = 'authority?user_id=' . $id;
//
//        $authority = Cache::get($cache_name);
//        if (!is_null($authority)) {
//            return $authority;
//        }

        $authority = DB::table('user')->where('user.id', $id)->join('user_role_rels', 'user.id', '=', 'user_id')
            ->join('role', 'role_id', '=', 'role.id')->selectRaw('MAX(add_user) AS add_user, MAX(modify_user) AS modify_user,
            MAX(add_role) AS add_role, MAX(modify_role) AS modify_role, MAX(`show`) AS `show`')->first();
//        Cache::put($cache_name, $authority, 10);
        return $authority;
    }

    public static function usernameAvailable($username) {
        return DB::table('user')->where('username', $username)->count() == 0;
    }

    public static function isUserFreezed($username) {
        return DB::table('user')->where('username', $username)->pluck('freezed') == 1;
    }

    public static function addUser($username, $password, $email) {
        return DB::table('user')->insertGetId(array(
            'username' => $username,
            'password' => hash('sha256', $password),
            'email' => $email,
        ));
    }

    public static function modifyUser($user_id, $password = null, $email = null) {
        $info = array();
        if (!empty($password)) {
            $info['password'] = hash('sha256', $password);
        }
        if (!empty($email)) {
            $info['email'] = $email;
        }
        try {
            return DB::table('user')->where('id', $user_id)->update($info);
        } catch (Exception $e) {
            return 0;
        }
    }

    public static function lockUserByName($username) {
        return DB::table('user')->where('username', $username)->update(array('freezed' => 1));
    }

    public static function unlockUserById($user_id) {
        return DB::table('user')->where('id', $user_id)->update(array('freezed' => 0));
    }

    public static function getLockedUsers() {
        return DB::table('user')->where('freezed', 1)->get(array('id', 'username'));
    }

}
