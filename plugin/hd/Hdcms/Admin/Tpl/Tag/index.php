<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>搜索关键词</title>
    <hdjs/>
    <js file="__GROUP__/static/js/js.js"/>
    <js file="__CONTROL_TPL__/js/tag.js"/>
    <css file="__CONTROL_TPL__/css/tag.css"/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="javascript:;" class="action">tag列表</a></li>
            <li><a href="__CONTROL__&m=add">添加tag</a></li>
        </ul>
    </div>
    <table class="table2 hd-form">
        <thead>
        <tr>
            <td class="w30">
                <input type="checkbox" id="select_all"/>
            </td>
            <td class="w30">tid</td>
            <td>关键词</td>
            <td class="w100">统计</td>
            <td class="w80">操作</td>
        </tr>
        </thead>
        <list from="$data" name="d">
            <tr>
                <td><input type="checkbox" name="tid[]" value="{$d.tid}"/></td>
                <td>{$d.tid}</td>
                <td>
                    <a href="{|U:edit,array('tid'=>$d['tid'])}">{$d.tag}</a>
                </td>
                <td>
                    {$d.total}
                </td>
                <td>
                    <a href="{|U:edit,array('tid'=>$d['tid'])}">编辑</a>
                    <span class="line">|</span>
                    <a href="javascript:;" onclick="del({$d.tid})">删除</a>
                </td>
            </tr>
        </list>
    </table>
    <div class="page1">
        {$page}
    </div>
</div>

<div class="position-bottom">
    <input type="button" class="hd-cancel" value="全选" onclick="select_all('.table2')"/>
    <input type="button" class="hd-cancel" value="反选" onclick="reverse_select('.table2')"/>
    <input type="button" class="hd-cancel" onclick="del()" value="批量删除"/>
</div>
</body>
</html>