<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>修改分类</title>
    <hdjs/>
    <css file="__GROUP__/static/css/common.css"/>
    <js file="__CONTROL_TPL__/js/edit_validate.js"/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Manage&m=index">友情链接</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Manage&m=audit">审核申请</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Manage&m=add">添加链接</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Type&m=add" class="action">修改分类</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Type&m=index">分类管理</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Set&m=set">模块配置</a></li>
        </ul>
    </div>
    <form action="" method="post" class="hd-form" enctype="multipart/form-data" onsubmit="return hd_submit(this,'{|U:index,array('g'=>'Plugin')}')">
        <input type="hidden" name="tid" value="{$field.tid}"/>
        <div class="title-header">添加分类</div>
        <table class="table1">
            <tr>
                <th class="w100">类型名称</th>
                <td>
                    <input type="text" name="type_name" value="{$field.type_name}" class="w200"/>
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