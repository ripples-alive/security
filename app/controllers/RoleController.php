<?php
/**
 * Created by PhpStorm.
 * User: Jayvic
 * Date: 14/12/14
 * Time: 下午11:25
 */

namespace Security\Controllers;

use BaseController;
use Input;
use View;

use Security\Models\Role;

class RoleController extends BaseController {

    public static function add() {
        $name = Input::get('name');

        if (empty($name)) {
            return View::make('role.add');
        }

        $role = array(
            'name' => $name,
            'add_user' => Input::has('add_user'),
            'modify_user' => Input::has('modify_user'),
            'add_role' => Input::has('add_role'),
            'modify_role' => Input::has('modify_role'),
            'show' => Input::has('show'),
        );

        if (!Role::addRole($role)) {
            return View::make('role.add', array('info' => '添加角色失败！'));
        }

        return View::make('role.add', array('info' => '添加角色成功！'));
    }

    public static function modify() {
        $role_id = Input::get('role_id');

        if (empty($role_id)) {
            return View::make('role.modify');
        }

        $role_info = array(
            'add_user' => Input::has('add_user'),
            'modify_user' => Input::has('modify_user'),
            'add_role' => Input::has('add_role'),
            'modify_role' => Input::has('modify_role'),
            'show' => Input::has('show'),
        );

        if (Role::updateRole($role_id, $role_info) <= 0) {
            return View::make('role.modify', array('info' => '更新角色失败！'));
        }

        return View::make('role.modify', array('info' => '更新角色成功！'));
    }

} 