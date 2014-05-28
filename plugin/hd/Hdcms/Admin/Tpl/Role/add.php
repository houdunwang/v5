<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>添加角色</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/js.js"/>
    <css file="__CONTROL_TPL__/css/css.css"/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="{|U:'index'}">角色列表</a></li>
            <li><a href="javascript:;" class="action">添加角色</a></li>
        </ul>
    </div>
    <div class="title-header">角色信息</div>
    <form action="{|U:'add'}" method="post" class="hd-form"  onsubmit="return hd_submit(this,'{|U:index}')">
        <input type="hidden" name="admin" value="1"/>
        <table class="table1">
            <tr>
                <th class="w100">角色名称</th>
                <td>
                    <input type="text" name="rname" class="w200"/>
                </td>
            </tr>
            <tr>
                <th class="w100">角色描述</th>
                <td>
                    <textarea name="title" class="w300 h100"></textarea>
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