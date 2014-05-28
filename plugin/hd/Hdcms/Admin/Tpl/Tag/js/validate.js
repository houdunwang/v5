$(function () {
    $('form').validate({
        tag: {
            rule: {
                required: true
            },
            error: {
                required: 'tag内容不能为空'
            },
            success: '输入正确'
        },
        total: {
            rule: {
                required: true,
                regexp:/^\d+$/i
            },
            error: {
                required: '统计数不能为空',
                regexp:'统计数输入错误'
            },
            success: '输入正确'
        }
    })
})