<?php
/**
 * Created by PhpStorm.
 * User: Jayvic
 * Date: 14/12/15
 * Time: 上午12:18
 */

namespace Security\Models;

use DB;

class Role {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'role';

    public static function addRole($role) {
        return DB::table('role')->insert($role);
    }

    public static function updateRole($role_id, $role_info) {
        return DB::table('role')->where('id', $role_id)->update($role_info);
    }

    public static function getAllList() {
        return DB::table('role')->where('id', '!=', 1)->orderBy('id')->get(array('id', 'name'));
    }

    public static function getUserRoles($user_id) {
        return DB::table('role')->join('user_role_rels', 'role.id', '=', 'role_id')->where('user_id', $user_id)
            ->where('role.id', '!=', 1)->selectRaw('role.id as id, name')->get();
    }

} 