<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>添加会员组</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/js.js"/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="{|U:'index'}">会员组列表</a></li>
            <li><a href="javascript:;" class="action">添加会员组</a></li>
        </ul>
    </div>
    <div class="title-header">添加会员组</div>
    <form action="{|U:add}" method="post" class="hd-form" onsubmit="return hd_submit(this,'{|U:index}');">
        <table class="table1">
            <tr>
                <th class="w100">会员组名</th>
                <td>
                    <input type="text" name="rname" class="w300" required=""/>
                </td>
            </tr>
            <tr>
                <th class="w100">积分小于</th>
                <td>
                    <input type="text" name="creditslower" class="w300" required=""/>
                </td>
            </tr>
            <tr>
                <th class="w100">评论不需要审核</th>
                <td>
                    <label>
                        <input type="radio" name="comment_state" value="1" /> 是
                    </label> 
                    <label>
                        <input type="radio" name="comment_state" value="0" checked="checked"/> 否
                    </label>
                </td>
            </tr>
            <tr>
                <th class="w100">允许发短消息</th>
                <td>
                    <label>
                        <input type="radio" name="allowsendmessage" value="1"/>是
                    </label> 
                    <label>
                        <input type="radio" name="allowsendmessage" value="0" checked="checked"/>否
                    </label>
                </td>
            </tr>
            <tr>
                <th class="w100">描述</th>
                <td>
                    <input type="text" name="title" class="w300"/>
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