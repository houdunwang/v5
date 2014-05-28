<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>添加会员</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/add.js"/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="{|U:'index'}">会员列表</a></li>
            <li><a href="javascript:;" class="action">添加会员</a></li>
        </ul>
    </div>
    <div class="title-header">添加会员组</div>
    <form method="post" class="hd-form" onsubmit="return hd_submit(this,'{|U:index}');">
        <table class="table1">
            <tr>
                <th class="w100">用户名</th>
                <td>
                    <input type="text" name="username" class="w300" required=""/>
                </td>
            </tr>
            <tr>
                <th class="w100">会员组</th>
                <td>
                    <select name="rid">
                        <list from="$role" name="r">
                            <option value="{$r.rid}">{$r.rname}</option>
                        </list>
                    </select>
                </td>
            </tr>
            <tr>
                <th class="w100">密码</th>
                <td>
                    <input type="password" name="password" class="w300" required=""/>
                </td>
            </tr>
            <tr>
                <th class="w100">确认密码</th>
                <td>
                    <input type="password" name="password_c" class="w300" required=""/>
                </td>
            </tr>
            <tr>
                <th class="w100">邮箱</th>
                <td>
                    <input type="text" name="email" class="w300"/>
                </td>
            </tr>
            <tr>
                <th class="w100">QQ</th>
                <td>
                    <input type="text" name="qq" class="w300"/>
                </td>
            </tr>
            <tr>
                <th class="w100">积分</th>
                <td>
                    <input type="text" name="credits" class="w300" value="{$hd.config.init_credits}" required=""/>
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