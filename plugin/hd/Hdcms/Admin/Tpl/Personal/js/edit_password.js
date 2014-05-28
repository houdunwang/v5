$(function () {
    $("form").validate({
        //验证规则
        old_password: {
            rule: {
                required: true,
                ajax: {url:CONTROL + "&m=check_password"}
            },
            error: {
                required: "旧密码不能为空",
                ajax: "旧密码输入错误"
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
        passwordc: {
            rule: {
                required: true,
                confirm: "password"
            },
            error: {
                required: "确认密码不能为空",
                confirm: "两次密码不一致"
            }
        }
    })
})