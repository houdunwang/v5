//添加属性验证
$(function () {
    $("form").validate({
        //验证规则
        flagname: {
            rule: {
                required: true
            },
            error: {
                required: "属性名不能为空"
            }
        },
        title: {
            rule: {
                required: true
            },
            error: {
                required: "属性别名不能为空"
            }
        }
    })
})