<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>修改会员资料</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/edit.js"/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="{|U:'index'}">会员列表</a></li>
            <li><a href="javascript:;" class="action">修改会员</a></li>
        </ul>
    </div>
    <div class="title-header">添加会员组</div>
    <form method="post" class="hd-form" onsubmit="return hd_submit(this,'{|U:index}')">
        <input type="hidden" name="uid" class="w300" value="{$field.uid}"/>
        <table class="table1">
            <tr>
                <th class="w100">用户名</th>
                <td>
                    {$field.username}
                </td>
            </tr>
            <tr>
                <th class="w100">会员组</th>
                <td>
                    <select name="gid">
                        <list from="$role" name="r">
                            <option value="{$r.rid}"
                            <if value="$field.gid eq $r.rid">selected=""</if>
                            >{$r.rname}</option>
                        </list>
                    </select>
                </td>
            </tr>
            <tr>
                <th class="w100">昵称</th>
                <td>
                    {$field.nickname}
                </td>
            </tr>
            <tr>
                <th class="w100">状态</th>
                <td>
                    <label><input type="checkbox" name="state" value="0"
                        <if value="$field.state eq 0">checked="checked"</if>
                        /> 锁定</label>
                </td>
            </tr>
            <tr>
                <th class="w100">密码</th>
                <td>
                    <input type="password" name="password" value="" class="w300"/>
                </td>
            </tr>
            <tr>
                <th class="w100">确认密码</th>
                <td>
                    <input type="password" name="password_c" value="" class="w300"/>
                </td>
            </tr>
            <tr>
                <th class="w100">邮箱</th>
                <td>
                    <input type="text" name="email" value="{$field.email}" class="w300"/>
                </td>
            </tr>
            <tr>
                <th class="w100">QQ</th>
                <td>
                    <input type="text" name="qq" value="{$field.qq}" class="w300"/>
                </td>
            </tr>
            <tr>
                <th class="w100">积分</th>
                <td>
                    <input type="text" name="credits" value="{$field.credits}" class="w300" required=""/>
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