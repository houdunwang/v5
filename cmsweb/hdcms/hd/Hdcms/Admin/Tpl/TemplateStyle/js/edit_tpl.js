//表单验证
$(function () {
    $("form").validate({
        //验证规则
        file_name: {
            rule: {
                required: true
            },
            error: {
                required: "模板文件名不能为空"
            }
        },
        content: {
            rule: {
                required: true
            },
            error: {
                required: "模板内容不能为空"
            }
        }
    })
})
$(function () {
    $("form").submit(function () {
        if ($(this).is_validate()) {
            if (confirm("确定修改吗?")) {
                $.ajax({
                    type: "post",
                    url: METH,
                    cache: false,
                    data: $(this).serialize(),
                    dataType:'JSON',
                    success: function (data) {
                        if (data.state == 1) {
                            $.dialog({
                                message: data.message,
                                type: "success",
                                close_handler: function () {
                                    if (window.opener)
                                        window.opener.location.reload();
                                    window.close();
                                }
                            });
                        } else{
                            $.dialog({
                                message: data.message,
                                type: "error"
                            });
                        }
                    }
                })
            }
        }
        return false;
    })
})