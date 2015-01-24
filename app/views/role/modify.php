<?php
/**
 * Created by PhpStorm.
 * User: Jayvic
 * Date: 14/12/14
 * Time: 下午11:22
 */
?>

<a href="/dashboard">返回</a>

<h3>Modify role</h3>

<form method="POST">
    <label for="">角色名</label>
    <select name="role_id">
        <?php
        $roles = \Security\Models\Role::getAllList();
        foreach ($roles as $role) {
            echo("<option value='{$role->id}'>{$role->name}</option>");
        }
        ?>
    </select>
    <br />
    <input type="checkbox" name="add_user" />
    <label for="">功能1</label>
    <br />
    <input type="checkbox" name="modify_user" />
    <label for="">功能2</label>
    <br />
    <input type="checkbox" name="add_role" />
    <label for="">功能3</label>
    <br />
    <input type="checkbox" name="modify_role" />
    <label for="">功能4</label>
    <br />
    <input type="checkbox" name="show" />
    <label for="">功能5</label>
    <br />
    <input type="submit" value="更新">
    <br />
    <?php
    if (isset($info)) {
        echo('<p style="color: red;">' . $info . '</p>');
    }
    ?>
</form>

<br />
<a href="/logout">登出</a>
