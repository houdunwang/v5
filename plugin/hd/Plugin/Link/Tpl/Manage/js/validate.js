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
                email:true
            },
            error: {
                email:'邮箱格式不正确'
            },
            success: '输入正确'
        },
        qq: {
            rule: {
                regexp:/^\d+$/
            },
            error: {
                regexp:'QQ输入错误'
            },
            success: '输入正确'
        }
    })
})