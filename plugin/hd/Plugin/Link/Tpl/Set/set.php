<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>友情链接配置</title>
    <hdjs/>
    <css file="__GROUP__/static/css/common.css"/>
    <js file="__CONTROL_TPL__/js/set.js"/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Manage&m=index">友情链接</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Manage&m=audit">审核申请</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Manage&m=add">添加链接</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Type&m=add">添加分类</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Type&m=index">分类管理</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Set&m=set" class="action">模块配置</a></li>
        </ul>
    </div>
    <form action="" method="post" class="hd-form" enctype="multipart/form-data">
        <div class="title-header">网站信息</div>
        <table class="table1">
            <tr>
                <th class="w100">网站名称</th>
                <td>
                    <input type="text" name="webname" value="{$field.webname}" class="w200"/>
                </td>
            </tr>
            <tr>
                <th class="w100">网址</th>
                <td>
                    <input type="text" name="url" value="{$field.url}" class="w200"/>
                </td>
            </tr>
            <tr>
                <th class="w100">站长邮箱</th>
                <td>
                    <input type="text" name="email" value="{$field.email}" class="w200"/>
                </td>
            </tr>
            <tr>
                <th class="w100">联系QQ</th>
                <td>
                    <input type="text" name="qq" value="{$field.qq}" class="w200"/>
                </td>
            </tr>
            <tr>
                <th class="w100">LOGO</th>
                <td>
                    <input type="file" name="logo"/>
                    <img src="__ROOT__/{$field.logo}" alt="网站LOGO" class="h50"/>
                </td>
            </tr>
            <tr>
                <th>申请说明</th>
                <td>
                    <textarea name="comment" class="w400 h120">{$field.comment}</textarea>
                </td>
            </tr>
        </table>
        <div class="title-header">申请配置</div>
        <table class="table1">
            <tr>
                <th class="w100">开放申请</th>
                <td>
                    <label><input type="radio" name="allow" value="1" <if value="$field.allow eq 1">checked="checked"</if>/> 是</label>
                    <label><input type="radio" name="allow" value="0" <if value="$field.allow eq 0">checked="checked"</if>/> 否</label>
                </td>
            </tr>
            <tr>
                <th class="w100">开启验证码</th>
                <td>
                    <label><input type="radio" name="code" value="1" <if value="$field.code eq 1">checked="checked"</if>/> 是</label>
                    <label><input type="radio" name="code" value="0" <if value="$field.code eq 0">checked="checked"</if>/> 否</label>
                </td>
            </tr>
        </table>
        <div class="position-bottom">
            <input type="submit" value="确定" class="hd-success"/>
        </div>
    </form>
</div>
</body>
</html>