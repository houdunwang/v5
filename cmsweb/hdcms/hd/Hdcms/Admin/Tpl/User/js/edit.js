$(function () {
    $("form").validate({
        username: {
            rule: {
                required: true, 
                ajax: {url: CONTROL + "&m=check_username", field: ['uid']}
            },
            error: {
                required: "密码不能为空",
                ajax: '帐号已经存在'
            }
        },
        password: {
            rule: {
                regexp: /^\w{5,}$/
            },
            error: {
                regexp: '密码不能小于5位'
            }
        },
        'password_c': {
            rule: {
                confirm: 'password'
            },
            error: {
                confirm: '两次密码不匹配'
            }
        },
        credits: {
            rule: {
                required: true,
                regexp: /^\d+$/
            },
            error: {
                required: "积分不能为空",
                regexp: "积分必须为数字"
            }
        },
        email: {
            rule: {
            	required: true, 
                email: true,
                ajax: {url: CONTROL + "&m=check_email",field:['uid']}
            },
            error: {
            	required: "邮箱不能为空",
                email: '邮箱格式不正确',
                ajax: '邮箱已经使用'
            }
        }
    })
})