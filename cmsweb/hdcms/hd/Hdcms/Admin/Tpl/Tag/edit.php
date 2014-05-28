<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>修改Tag</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/addEdit.js"/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="{|U:'index'}">tag列表</a></li>
            <li><a href="javascript:;" class="action">修改tag</a></li>
        </ul>
    </div>
    <div class="title-header">修改Tag</div>
    <form action="{|U:'edit'}" method="post" onsubmit="return hd_submit(this,'{|U:index}')" class="hd-form">
        <input type="hidden" name="tid" value="{$field.tid}"/>
        <table class="table1">
            <tr>
                <th class="w100">tag</th>
                <td>
                    <input type="text" name="tag" value="{$field.tag}" class="w200"/>
                </td>
            </tr>
            <tr>
                <th class="w100">统计</th>
                <td>
                    <input type="text" name="total" value="{$field.total}" class="w200"/>
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