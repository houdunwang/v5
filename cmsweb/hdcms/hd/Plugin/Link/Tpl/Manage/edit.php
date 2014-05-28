<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>添加分类</title>
    <hdjs/>
    <css file="__GROUP__/static/css/common.css"/>
    <js file="__CONTROL_TPL__/js/validate.js"/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Manage&m=index">友情链接</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Manage&m=audit">审核申请</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Manage&m=add" class="action">编辑链接</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Type&m=add">添加分类</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Type&m=index">分类管理</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Set&m=set">模块配置</a></li>
        </ul>
    </div>
    <form action="" method="post" class="hd-form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="{$field.id}"/>
        <div class="title-header">添加分类</div>
        <table class="table1">
            <tr>
                <th class="w100">网站名称<span class="star">*</span> </th>
                <td>
                    <input type="text" name="webname" class="w200" value="{$field.webname}"/>
                </td>
            </tr>
            <tr>
                <th class="w100">网址<span class="star">*</span></th>
                <td>
                    <input type="text" name="url" class="w200" value="{$field.url}"/>
                </td>
            </tr>
            <tr>
                <th class="w100">分类</th>
                <td>
                    <select name="tid">
                        <list from="$type" name="t">
                            <option value="{$t.tid}" <if value="$t.tid==$field.tid">selected="selected"</if>>{$t.type_name}</option>
                        </list>
                    </select>
                </td>
            </tr>
            <tr>
                <th class="w100">站长邮箱</th>
                <td>
                    <input type="text" name="email" class="w200" value="{$field.email}"/>
                </td>
            </tr>
            <tr>
                <th class="w100">联系QQ</th>
                <td>
                    <input type="text" name="qq" class="w200" value="{$field.qq}"/>
                </td>
            </tr>
            <tr>
                <th class="w100">LOGO</th>
                <td>
                    <input type="file" name="logo"/>
                    <if value="$field.logo">
                        <img src="__ROOT__/{$field.logo}" alt="网站LOGO" class="h50"/>
                    </if>
                    <span class="message">如果是图片链接，需要上传LOGO图片</span>
                </td>
            </tr>
            <tr>
                <th>网站介绍</th>
                <td>
                    <textarea name="comment" class="w400 h120">{$field.comment}</textarea>
                </td>
            </tr>
            <tr>
                <th class="w100">已审核</th>
                <td>
                    <label><input type="radio" name="state" value="1" <if value="$field.state eq 1">checked="checked"</if>/> 是</label>
                    <label><input type="radio" name="state" value="0" <if value="$field.state eq 0">checked="checked"</if>/> 否</label>
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