<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>友情链接类型列表</title>
    <hdjs/>
    <css file="__GROUP__/static/css/common.css"/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Manage&m=index">友情链接</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Manage&m=audit">审核申请</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Manage&m=add">添加链接</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Type&m=add">添加分类</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Type&m=index" class="action">分类管理</a></li>
            <li><a href="__WEB__?g=Plugin&a=Link&c=Set&m=set">模块配置</a></li>
        </ul>
    </div>
    <table class="table2 hd-form">
        <thead>
        <tr>
            <td class="w30">tid</td>
            <td>类型名称</td>
            <td class="w100">系统内置</td>
            <td class="w100">操作</td>
        </tr>
        </thead>
        <tbody>
        <list from="$type" name="t">
            <tr>
                <td>{$t.tid}</td>
                <td>{$t.type_name}</td>
                <td>
                    <if value="$t.system eq 1">是<else>否</if>
                </td>
                <td>
                    <a href="{|U:'edit',array('g'=>'Plugin','tid'=>$t['tid'])}">编辑</a>
                    <if value="$t.system==1">
                        <span style="color:#999;">删除</span>
                    <else/>
                        <a href="javascript:hd_ajax('{|U:'del',array('g'=>'Plugin')}',{tid:{$t.tid}});">删除</a>
                    </if>

                </td>
            </tr>
        </list>
        </tbody>
    </table>
</div>
</body>
</html>