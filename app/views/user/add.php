<?php
/**
 * Created by PhpStorm.
 * User: Jayvic
 * Date: 14/12/14
 * Time: 下午11:21
 */
?>

<a href="/dashboard">返回</a>

<h3>Add user</h3>

<form method="POST">
    <label for="">用户名</label>
    <input type="text" name="username" />
    <br />
    <label for="">密码</label>
    <input type="password" name="password" />
    <br />
    <label for="">email</label>
    <input type="text" name="email" />
    <br />
    <p>选择角色</p>
    <?php
    $roles = \Security\Models\Role::getAllList();
    foreach ($roles as $role) {
        echo("<input type='checkbox' name='role{$role->id}' />");
        echo("<label for=''>{$role->name}</label>");
        echo("<br />");
    }
    ?>
    <input type="submit" value="添加">
    <br />
    <?php
    if (isset($info)) {
        echo('<p style="color: red;">' . $info . '</p>');
    }
    ?>
</form>

<br />
<a href="/logout">登出</a>
