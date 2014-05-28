<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>后台菜单管理</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/js.js"/>
    <css file="__CONTROL_TPL__/css/css.css"/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="javascript:;" class="action">导航列表</a></li>
            <li><a href="{|U:'add',array('pid'=>0)}">添加导航</a></li>
            <li><a href="javascript:hd_ajax('{|U:update_cache}');">更新缓存</a></li>
        </ul>
    </div>
    <table class="table2 hd-form form-inline">
        <thead>
        <tr>
            <td class="w50">排序</td>
            <td class="w50">nid</td>
            <td>菜单名称</td>
            <td class="w50">状态</td>
            <td class="w150">操作</td>
        </tr>
        </thead>
        <list from="$navigation" name="n">
            <tr>
                <td>
                    <input type="text" class="w30" value="{$n.list_order}" name="list_order[{$n.nid}]"/>
                </td>
                <td>{$n.nid}</td>
                <td>{$n._name}</td>
                <td>
                    <if value="$n.state==1">
                        显示
                        <else>
                        不显示
                    </if>
                </td>
                <td style="text-align: right">
                    <if value="$n._level==3">
                        <span class="disabled">添加子菜单  | </span>
                    <else>
                        <a href="{|U('add',array('pid'=>$n['nid']))}">添加子菜单</a> |
                    </if>

                    <if value="$n.is_system==0">
                        <a href="{|U('edit',array('nid'=>$n['nid']))}">修改</a> |
                        <a href="javascript:hd_ajax('{|U:del}',{nid:{$n.nid}})">删除</a>
                    <else/>
                         <span class="disabled">修改 | </span>
                         <span class="disabled">删除</span>
                    </if>
                </td>
            </tr>
        </list>
    </table>
</div>
<div class="position-bottom">
    <input type="button" class="hd-success" value="更改排序" onclick="update_order();"/>
</div>
</body>
</html>