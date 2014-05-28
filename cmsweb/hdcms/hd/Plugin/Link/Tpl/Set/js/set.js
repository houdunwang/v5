$(function () {
    $('form').validate({
        webname: {
            rule: {
                required: true
            },
            error: {
                required: '网站名称不能为空'
            },
            success: '输入正确'
        },
        url: {
            rule: {
                required: true,
                regexp:/^http/i
            },
            error: {
                required: '网址不能为空',
                regexp:'网址输入错误'
            },
            success: '输入正确'
        },
        email: {
            rule: {
                required: true,
                email:true
            },
            error: {
                required: '联系邮箱不能为空',
                email:'邮箱格式不正确'
            },
            success: '输入正确'
        },
        qq: {
            rule: {
                required: true,
                regexp:/^\d+$/
            },
            error: {
                required: '联系QQ不能为空',
                regexp:'QQ输入错误'
            },
            success: '输入正确'
        }
    })
})