<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>添加管理员</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/add_validate.js"/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="{|U:'index'}">管理员</a></li>
            <li><a href="javascript:;" class="action">添加管理员</a></li>
        </ul>
    </div>
    <div class="title-header">管理员信息</div>
    <form action="{|U:'add'}" method="post" class="form-inline hd-form" onsubmit="return hd_submit(this,'__CONTROL__')">
        <input type="hidden" name="admin" value="1"/>
        <table class="table1">
            <tr>
                <th class="w100">帐号</th>
                <td>
                    <input type="text" name="username" class="w200"/>
                </td>
            </tr>
            <tr>
                <th class="w100">所属角色</th>
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
                    <input type="password" name="password" class="w200"/>
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
                    <input type="text" name="email" class="w200"/>
                </td>
            </tr>
            <tr>
                <th class="w100">积分</th>
                <td>
                    <input type="text" name="credits" class="w200" value="{$hd.config.init_credits}"/>
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
	$("form").validate({
        //验证规则
        username: {
            rule: {
                required: true,
                ajax: {url: CONTROL + '&m=check_username', field: ['uid']}
            },
            error: {
                required: "管理员名不能为空",
                ajax: '帐号已经存在'
            }
        },
        email: {
            rule: {
                required: true,
                email: true,
                ajax: {url: CONTROL + '&m=check_email'}
            },
            error: {
                required: '邮箱不能为空',
                email: "邮箱输入错误",
                ajax: '邮箱已经存在'
            }

        },
        password: {
            rule: {
                required: true,
                regexp: /^\w{5,}$/
            },
            error: {
                required: "密码不能为空",
                regexp: "密码不能小于5位"
            }
        },
        c_password: {
            rule: {
                required: true,
                confirm: "password"
            },
            error: {
                required: "确认密码不能为空",
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
</script>
</body>
</html>