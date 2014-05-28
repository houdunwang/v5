<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>上传文件管理</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/js.js"/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="javascript:;" class="action">附件管理</a></li>
        </ul>
    </div>
    <table class="table2">
        <thead>
        <tr>
            <td class="w50">ID</td>
            <td class="w100">预览</td>
            <td >文件名</td>
            <td>大小</td>
            <td class="w200">上传时间</td>
            <td class="w100">用户id</td>
            <td class="w50">操作</td>
        </tr>
        </thead>
        <list from="$upload" name="u">
            <tr>
                <td>{$u.id}</td>
                <td>
                	<if value="$u.image">
	                	<a href="{$u.pic}" target="_blank">
	                    <img src="{$u.pic}" class="w60 h30" title="点击预览大图" onmouseover="view_image(this)"/>
	                    </a>
	                <else>
	                    <img src="{$u.pic}" class="w60 h30" title="点击预览大图" />
                    </if>
                </td>
                <td>
                    {$u.basename}
                </td>
                <td>
                    {$u.size|get_size}
                </td>
                <td>
                    {$u.uptime|date:"Y-m-d",@@}
                </td>
                <td>
                    {$u.username}
                </td>
                <td>
                    <a href="javascript:;"  onclick="hd_confirm('确认删除吗？',function(){hd_ajax('{|U:del}',{id:{$u.id}}})">删除</a>
                </td>
            </tr>
        </list>
    </table>
    <div class="page1">
        {$page}
    </div>
</div>
</body>
</html>