$(function () {
    //表单验证
    $(function () {
        $("form").validate({
            title: {
                rule: {
                    required: true
                },
                error: {
                    required: "标题不能为空"
                }
            },
            tag: {
                rule: {
                    required: true
                },
                error: {
                    required: "标签不能为空"
                },
                message:'用逗号分隔'
            },
            read_credits: {
                rule: {
                    required: true,
                    regexp: /^\d+$/
                },
                error: {
                    required: "阅读积分不能为空",
                    regexp: '必须为数字'
                }
            }
        })
    })
    //submit添加修改文章
    $('form').submit(function () {
        //验证内容
        if (hd_content && hd_content.isEmpty()) {
            alert('内容不能为空');
        }
        if ($(this).is_validate()) {
            $.ajax({
                dataType: 'json',
                data: $(this).serialize(),
                type: 'POST',
                cache: false,
                success: function (data) {
                    if (data.state == 1) {
                        $.dialog({
                            "message": data.message,
                            "type": "success",
                            "timeout": 2,
                            "close_handler": function () {
                                if (window.opener) {
                                    window.opener.location.reload();
                                }
                                hd_close_window();
                                window.close();
                            }
                        });
                    } else {
                        $.dialog({
                            "message": data.message,
                            "type": "error",
                            "timeout": 2,
                            "close_handler": function () {
                                hd_close_window();
                            }
                        });
                    }
                }
            })
        }
        return false;
    })
})