<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>评论管理</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/js.js"/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="{|U:'index',array('comment_state'=>1)}"
                <if value="$hd.get.comment_state==1">class="action"</if>
                >已审核</a></li>
           <li><a href="{|U:'index',array('comment_state'=>0)}"
                <if value="$hd.get.comment_state==0">class="action"</if>
                >未审核</a></li>
        </ul>
    </div>
    <table class="table2 hd-form">
        <thead>
        <tr>
            <td class="w30">
                <input type="checkbox" id="select_all"/>
            </td>
            <td class="w30">comment_id</td>
            <td>评论内容</td>
            <td class="w50">状态</td>
            <td class="w100">uid</td>
            <td class="w100">发表时间</td>
        </tr>
        </thead>
        <list from="$data" name="d">
            <tr>
                <td><input type="checkbox" name="comment_id[]" value="{$d.comment_id}"/></td>
                <td>{$d.comment_id}</td>
                <td>
                    {$d.content}
                </td>
                <td>
                    <if value="$d.comment_state==1">已审核<else/>未审核</if>
                </td>
                <td>
                    {$d.uid}
                </td>
                <td>{$d.pubtime|date:"Y-m-d",@@}</td>
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
    <input type="button" class="hd-cancel" onclick="audit(1)" value="审核"/>
    <input type="button" class="hd-cancel" onclick="audit(0)" value="取消审核"/>
</div>
</body>
</html>