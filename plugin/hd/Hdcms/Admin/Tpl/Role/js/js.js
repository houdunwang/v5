//表单验证 添加管理员
$(function () {
    $("form").validate({
        //验证规则
        rname: {
            rule: {
                required: true,
                ajax: {url: CONTROL + "&m=check_role", field: ["rid"]}
            },
            error: {
                required: '角色名称不能为空',
                ajax: "角色已经存在"
            }
        }
    })
})




















