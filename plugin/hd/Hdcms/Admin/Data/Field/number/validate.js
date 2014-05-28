//表单验证
$(function () {
    $("form").validate({
        'set[num_integer]': {//整数位数
            rule: {
                required: true,
                regexp: /^\d+$/
            },
            error: {
                required: "请输入数字",
                regexp: "请输入数字"
            }
        },
        'set[num_decimal]': {//小数位数
            rule: {
                regexp: /^\d+$/
            },
            error: {
                regexp: "请输入数字"
            }
        },
        'set[size]': {//显示长度
            rule: {
                regexp: /^\d+$/
            },
            error: {
                regexp: "请输入数字"
            },
            message: "px"
        },
        'set[validation]': {//验证规则
            rule: {
                regexp: /^\/.+\/$/
            },
            error: {
                regexp: "请输入正则"
            }
        }
    })
})