<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>修改密码</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/edit_password.js"/>
</head>
<body>
<div class="wrap">
    <div class="title-header">修改密码</div>
    <form action="__METH__" method="post" onsubmit="return hd_submit(this)" class="hd-form">
        <table class="table1">
            <tr>
                <th class="w100">管理员名称</th>
                <td>
                    {$user.username}
                </td>
            </tr>
            <tr>
                <th class="w100">旧密码</th>
                <td>
                    <input type="password" name="old_password" class="w200"/>
                </td>
            </tr>
            <tr>
                <th class="w100">新密码</th>
                <td>
                    <input type="password" name="password" class="w200"/>
                </td>
            </tr>
            <tr>
                <th class="w100">确认密码</th>
                <td>
                    <input type="password" name="passwordc" class="w200"/>
                </td>
            </tr>
        </table>
        <div class="position-bottom">
            <input type="submit" class="hd-success" value="确定"/>
        </div>
    </form>
</div>
</body>
</html>