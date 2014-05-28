//表单验证
$(function () {
    $("form").validate({
        'set[width]': {
            rule: {
                required: true,
                regexp: /^\d+$/
            },
            error: {
                required: "请输入数字",
                regexp: "请输入数字"
            }, message: "px"
        },
        'set[height]': {//验证规则
            rule: {
                required: true,
                regexp: /^\d+$/
            },
            error: {
                required: "请输入数字",
                regexp: "请输入数字"
            }, message: "px"
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