<?php
/**
 * Created by PhpStorm.
 * User: Jayvic
 * Date: 14/12/14
 * Time: 下午9:59
 */
?>

<form method="POST">
    <label for="">用户名</label>
    <input type="text" name="username" />
    <br />
    <label for="">密码</label>
    <input type="password" name="password" />
    <br />
    <label for="">验证码</label>
    <input type="text" name="code" />
    <img src="/verify_code" />
    <br />
    <input type="submit" value="登陆" />
    <?php
    if (isset($info)) {
        echo('<p style="color: red;">' . $info . '</p>');
    }
    ?>
</form>