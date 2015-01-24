<?php
/**
 * Created by PhpStorm.
 * User: Jayvic
 * Date: 14/12/15
 * Time: 下午12:30
 */

namespace Security\Models;


use DB;

class UserRoleRels {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_role_rels';

    public static function addRolesForUser($user_id, $roles) {
        if (count($roles) == 0) {
            return 0;
        }
        $rels = array();
        foreach ($roles as $role) {
            $rels[] = array('user_id' => $user_id, 'role_id' => $role);
        }
        return DB::table('user_role_rels')->insert($rels);
    }

    public static function removeRolesForUser($user_id, $roles) {
        if (count($roles) == 0) {
            return 0;
        }
        return DB::table('user_role_rels')->where('user_id', $user_id)->whereIn('role_id', $roles)->delete();
    }

} 