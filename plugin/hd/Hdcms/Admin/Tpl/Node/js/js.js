//表单验证
$(function () {
    $("form").validate({
        //验证规则
        title: {
            rule: {
                required: true
            },
            error: {
                required: "菜单名称不能为空"
            }
        }
    })
})

//更改列表排序
function update_order() {
    var data = $("[name*='list_order']").serialize();
    $.post(CONTROL + "&m=update_order", data, function (data) {
        if (data.state == 1) {
            $.dialog({
                "message": data.message,
                "type": "success",
                "close_handler": function () {
                    location.href = URL;
                }
            });
        } else {
            $.dialog({
                "message": "排序修改失败",
                "type": "error"
            });
        }
    }, 'json')
}


































