<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>修改管理员</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/edit_validate.js"/>
    
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="{|U:'index'}">管理员</a></li>
            <li><a href="javascript:;" class="action">修改管理员</a></li>
        </ul>
    </div>
    <div class="title-header">管理员信息</div>
    <form action="{|U:'edit'}" method="post" class="form-inline hd-form" onsubmit ="return hd_submit(this,'__CONTROL__')">
        <input type="hidden" name="uid" value="{$field.uid}"/>
        <table class="table1">
            <tr>
                <th class="w100">帐号</th>
                <td>
                    {$field.username}
                </td>
            </tr>
            <tr>
                <th class="w100">所属角色</th>
                <td>
                    <select name="rid">
                        <list from="$role" name="r">
                            <option value="{$r.rid}" <if value="$field.rid eq $r.rid">selected="selected"</if>>{$r.rname}</option>
                        </list>
                    </select>
                </td>
            </tr>
            <tr>
                <th class="w100">密码</th>
                <td>
                    <input type="password" name="password" class="w200" value=""/>
                </td>
            </tr>
            <tr>
                <th class="w100">确认密码</th>
                <td>
                    <input type="password" name="c_password" class="w200"/>
                </td>
            </tr>
            <tr>
                <th class="w100">邮箱</th>
                <td>
                    <input type="text" name="email" value="{$field.email}" class="w200"/>
                </td>
            </tr>
            <tr>
                <th class="w100">积分</th>
                <td>
                    <input type="text" name="credits" class="w200" value="{$field.credits}"/>
                </td>
            </tr>
        </table>
        <div class="position-bottom">
            <input type="submit" class="hd-success" value="确定"/>
            <input type="button" class="hd-cancel" value="取消" onclick="location.href='__CONTROL__'"/>
        </div>
    </form>
</div>
<script type="text/javascript" charset="utf-8">
    	$(function () {
    $("form").validate({
        email: {
            rule: {
                required: true,
                email: true,
                ajax: {url: CONTROL + '&m=check_email',field:['uid']}
            },
            error: {
                required: '邮箱不能为空',
                email: "邮箱输入错误",
                ajax: '邮箱已经存在'
            }

        },
        password: {
            rule: {
                regexp: /^\w{5,}$/
            },
            error: {
                regexp: "密码不能小于5位"
            }
        },
        c_password: {
            rule: {
                confirm: "password"
            },
            error: {
                confirm: "两次密码不一致"
            }
        },
        credits: {
            rule: {
                required: true,
                regexp: /^\d+$/
            },
            error: {
                required: "积分不能为空",
                regexp: "必须为数字"
            }
        }

    })
})
    </script>
</body>
</html>