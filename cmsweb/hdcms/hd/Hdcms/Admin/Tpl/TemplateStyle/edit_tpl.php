<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>修改模板</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/edit_tpl.js"/>
</head>
<body>
<div class="wrap" style="bottom: 0px;">
    <div class="title-header">温馨提示</div>
    <div class="help">
        <p>1 修改模板后，需要删除缓存与重新生成静态文件才会看到效果</p>

        <p>2 修改模板文件前，请做好备份操作！</p>
    </div>
    <div class="title-header">修改模板</div>
    <form action="{|U:add}" method="post" onsubmit="return false">
        <input type="hidden" name="file_path" value="{$field.file_path}" />
        <!--右侧缩略图区域-->
        <table class="table1 hd-form">
            <tr>
                <th class="w100">文件名</th>
                <td>
                    <input type="text" name="file_name" value="{$field.file_name}" class="w300"/>
                </td>
            </tr>
            <tr>
                <th class="w100">内容</th>
                <td>
                    <textarea name="content" style="width:80%;height:500px;">{$field.content}</textarea>
                </td>
            </tr>
        </table>
        <div class="position-bottom">
            <input type="submit" value="确定" class="hd-success"/>
            <input type="button" value="放弃" class="hd-cancel" onclick="hd_close_window('放弃编辑吗？')"/>
        </div>
    </form>
</div>
</body>
</html>