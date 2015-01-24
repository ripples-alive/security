<?php
/**
 * Created by PhpStorm.
 * User: Jayvic
 * Date: 14/12/15
 * Time: 下午1:29
 */
?>

<a href="/dashboard">返回</a>

<h3>Unlock user</h3>

<form method="POST">
    <label for="">用户名</label>
    <select name="user_id">
        <?php
        $users = \Security\Models\User::getLockedUsers();
        foreach ($users as $user) {
            echo("<option value='{$user->id}'>{$user->username}</option>");
        }
        ?>
    </select>
    <br />
    <input type="submit" value="解锁">
    <br />
    <?php
    if (isset($info)) {
        echo('<p style="color: red;">' . $info . '</p>');
    }
    ?>
</form>

<br />
<a href="/logout">登出</a>
