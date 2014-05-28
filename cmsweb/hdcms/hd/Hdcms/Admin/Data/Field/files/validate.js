//表单验证
$(function () {
    $("form").validate({
        'set[input_width]': {//文本框宽度
            rule: {
                required: true,
                regexp: /^\d+$/
            },
            error: {
                required: "请输入数字",
                regexp: "请输入数字"
            },
            message: "px"
        },

        'set[num]': {//允许上传数量
            rule: {
                required: true,
                regexp: /^\d+$/
            },
            error: {
                required: "请输入数字",
                regexp: "请输入数字"
            },
            message: "个"
        },
        'set[filetype]': {//允许上传数量
            rule: {
                required: true,
            },
            error: {
                required: "文件类型不能为空",
            },
            message: "上传文件类型，用逗号分隔。如: zip,doc"
        },
        'set[down_credits]': {//下载金币数
            rule: {
                required: true,
                regexp: /^\d+$/
            },
            error: {
                required: "请输入数字",
                regexp: "下载金币"
            },
            message: "个"
        }
    })
})