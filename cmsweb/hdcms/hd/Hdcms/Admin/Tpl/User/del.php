<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>删除会员</title>
    <hdjs/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="{|U:'index'}">会员列表</a></li>
            <li><a href="javascript:;" class="action">删除会员</a></li>
        </ul>
    </div>
    <div class="title-header">删除会员</div>
    <form method="post" class="hd-form" onsubmit="return hd_submit(this,'{|U:index}');">
    	<input type="hidden" name="uid" value="{$field.uid}"/>
        <table class="table1">
            <tr>
                <th class="w100">用户名</th>
                <td>
                    {$field.username}
                </td>
            </tr>
            <tr>
                <th class="w100">删除选项</th>
                <td>
                    <label><input type="checkbox" name="delcontent" checked=""/> 文章</label> 
                    <label><input type="checkbox" name="delcomment" checked=""/> 评论</label> 
                    <label><input type="checkbox" name="delupload" checked=""/> 附件</label> 
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