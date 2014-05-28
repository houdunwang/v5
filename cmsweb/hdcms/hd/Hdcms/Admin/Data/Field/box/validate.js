//表单验证
$(function () {
    $("form").validate({
        'set[options]': {//select选项
            rule: {
                required: true
            },
            error: {
                required: "选项列表不能为空"
            },
            message: "例：1|男,2|女"
        },
        'set[default]': {//select默认值
            rule: {
                regexp: /^\d+$/
            },
            error: {
                regexp: "请输入数字"
            }
        }
    })
})