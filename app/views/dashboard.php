<?php
/**
 * Created by PhpStorm.
 * User: Jayvic
 * Date: 14/12/14
 * Time: 下午11:03
 */
?>

<h3>You are <?php echo $user->username; ?></h3>
<h3>Your email is <?php echo $user->email; ?></h3>

<?php
$authority = \Security\Models\User::getAuthorityById($user->id);
if ($authority->add_user) {
    echo("<a href='/user/add'>功能1：添加用户</a><br />");
}
if ($authority->modify_user) {
    echo("<a href='/user/modify'>功能2：修改用户信息</a><br />");
}
if ($authority->add_role) {
    echo("<a href='/role/add'>功能3：添加角色</a><br />");
}
if ($authority->modify_role) {
    echo("<a href='/role/modify'>功能4：修改角色信息</a><br />");
}
if ($authority->show) {
    echo("<a href='/show'>功能5：显示网站说明</a><br />");
}
if ($user->id == 1) {
    echo("<a href='/user/unlock'>管理员功能：解锁用户</a><br />");
}
?>

<br />
<a href="/logout">登出</a>