$(function () {
		//改变li样式
    $(".tpl-list li").mouseover(function () {
        $(this).addClass("active")
    }).mouseout(function () {
            $(this).removeClass("active")
    })
})

