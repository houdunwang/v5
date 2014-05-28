<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>个人资料修改</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/edit_info.js"/>
</head>
<body>
<div class="wrap">
    <div class="title-header">个人资料修改</div>
    <form action="{|U:'edit_info'}" method="post" onsubmit="return hd_submit(this,'__METH__')" class="hd-form">
        <input type="hidden" name="uid" value="{$hd.session.uid}"/>
        <table class="table1">
            <tr>
                <th class="w100">管理员名称</th>
                <td>
                    {$user.username}
                </td>
            </tr>
            <tr>
                <th class="w100">最后登录时间</th>
                <td>
                    {$user.logintime|date:"Y-m-d",@@}
                </td>
            </tr>
            <tr>
                <th class="w100">最后登录IP</th>
                <td>
                    {$user.lastip}
                </td>
            </tr>
            <tr>
                <th class="w100">昵称</th>
                <td>
                    <input type="text" name="nickname" class="w200" value="{$user.nickname}"/>
                </td>
            </tr>
            <tr>
                <th class="w100">邮箱</th>
                <td>
                    <input type="text" name="email" class="w200" value="{$user.email}"/>
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