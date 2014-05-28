<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>链接列表</title>
    <hdjs/>
    <css file="__GROUP__/static/css/common.css"/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Manage&m=index" class="action">友情链接</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Manage&m=audit">审核申请</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Manage&m=add">添加链接</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Type&m=add">添加分类</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Type&m=index">分类管理</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Set&m=set">模块配置</a></li>
        </ul>
    </div>
    <table class="table2 hd-form">
        <thead>
        <tr>
            <td class="w30">id</td>
            <td>网站名称</td>
            <td class="w150">分类(tid)</td>
            <td class="w150">logo</td>
            <td class="w150">站长邮箱</td>
            <td class="w150">站长QQ</td>
            <td class="w100">操作</td>
        </tr>
        </thead>
        <tbody>
        <list from="$link" name="l">
            <tr>
                <td>{$l.id}</td>
                <td>
                    <a href="{$l.url}" target="_blank">{$l.webname}</a>
                </td>
                <td>{$l.type_name}({$l.tid})</td>
                <td>
                    <img src="__ROOT__/{$l.logo}" class="h30"/></td>
                <td>{$l.email}</td>
                <td>{$l.qq}</td>
                <td>
                    <a href="{$l.url}" target="_blank">查看</a> |
                    <a href="{|U:'edit',array('g'=>'Plugin','id'=>$l['id'])}">编辑</a> |
                    <a href="{|U:'del',array('g'=>'Plugin','id'=>$l['id'])}">删除</a>
                </td>
            </tr>
        </list>
        </tbody>
    </table>
</div>
</body>
</html>