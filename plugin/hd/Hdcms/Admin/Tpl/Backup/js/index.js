//------------------------------------------全选与反选  checkbox
$(function () {
    //checkbox选择
    $(".s_all_ck").click(function () {
        $("input[name*='dir']").attr("checked", !!$(this).attr("checked"));
    })
})

//删除备份
function del_backup() {
    if (check_select_table()) {
        if (confirm("确定删除目录吗？")) {
            hd_ajax(CONTROL + '&m=del', $("[name*='dir']:checked").serialize());
        }
    }
}
//检查有没有选择备份目录
function check_select_table() {
    if ($("[name*='dir']:checked").length == 0) {
        alert("你还没有选择表");
        return false;
    }
    return true;
}