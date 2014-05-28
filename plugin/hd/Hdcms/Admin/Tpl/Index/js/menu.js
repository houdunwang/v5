var menu_cache = {parent: {}, iframe: {}, link: {}};
//常用菜单缓存
menu_cache.parent[0] = true;
menu_cache.iframe[0] = true;
//点击顶部导航
function get_left_menu(nid) {
    $("div.nav div.top_menu a").removeClass("action");
    var obj = $('a[class=top_menu][nid=' + nid + ']');
    $(obj).addClass("action");
    //读取缓存
    if (menu_cache.parent[nid]) {
        //隐藏所有左侧菜单
        $("div.left_menu div").hide();
        //显示当前菜单
        $("div.left_menu div.nid_" + nid).show();
        set_first_action(nid);
    } else {//缓存不存在
        flush_left_menu(nid);
    }
}
/**
 * 点击左侧第一个菜单
 */
function set_first_action(nid) {
    //触发第一个3级菜单点击
    var win = top || opener;
    $(win.document).find("div.nid_" + nid).find('a').eq(0).trigger('click');
}
//刷新左侧菜单
function flush_left_menu(nid) {
    $("div.left_menu div.nid_" + nid).remove();
    $.ajax({
        type: "GET",
        url: CONTROL+'&m=getChildMenu',
        data: {pid: nid},
        cache: false,
        success: function (html) {
            menu_cache.parent[nid] = true;
            //隐藏所有左侧菜单
            $("div.left_menu div").hide();
            $("div.left_menu").append(html);
            //触发第一个3级菜单点击
            set_first_action(nid);
        }
    });
}

//左侧子导航点击
function get_content(obj, nid) {
    //改变样式
    $("div.left_menu dd a").removeClass("action");
    $(obj).addClass("action");
    //读取缓存
    show_iframe(nid);
    //添加历史导航
    add_menu_history(nid, $(obj).text());
    //更改位置
    favorite_menu_position(nid);
}
//显示iframe显示内容
function show_iframe(nid) {
    //隐藏所有iframe
    $("div.top_content iframe").hide();
    if (menu_cache.iframe[nid]) {
        var frm = $("iframe[nid='" + nid + "']");
        frm.show();
    } else {
        var obj = $("a[nid='" + nid + "']");
        var url = $(obj).attr("url");
        var html = '<iframe nid="' + nid + '" src="' + url + "&_=" + Math.random() + '" scrolling="auto" frameborder="0" style="height: 100%;width: 100%;"></iframe>';
        $("div.top_content").append(html);
        //压入缓存
        menu_cache.iframe[nid] = true;
    }
}
//添加历史导航
function add_menu_history(nid, title) {
    //不存在菜单时添加
    if ($("div.favorite_menu a[nid='" + nid + "']").length == 0) {
        var html = "<li class='action' nid='" + nid + "'>";
        html += "<a href='javascript:;' class='menu' nid='" + nid + "'>" + title + "</a>";
        html += "<a class='close' nid='" + nid + "'>x</a></li>";
        $("div.favorite_menu ul").append(html);
    }
    //更改当前点击样式
    $("div.favorite_menu li").removeClass("action");
    $("div.favorite_menu a.menu[nid='" + nid + "']").parent().addClass("action");
}
//历史导航点击
$(function () {
    $("div.favorite_menu a.menu").live("click", function () {
        //移除所有点击的样式
        $("div.favorite_menu li").removeClass("action");
        //当前点击的链接加action样式
        $(this).parent("li").addClass("action");
        var nid = $(this).attr("nid");
        favorite_menu_position(nid);
        show_iframe(nid);
    })
    //关闭历史导航
    $("div.favorite_menu ul li a.close").live("click", function () {
        var nid = $(this).attr("nid");
        //显示上一个iframe
        $("iframe[nid='" + nid + "']").prev("iframe").show();
        //删除关闭的iframe
        $("iframe[nid='" + nid + "']").remove();
        //移除li样式action
        $("div.favorite_menu ul li").removeClass("action");
        //更改上一个菜单样式
        $(this).parent().prev("li").addClass("action");
        //移除菜单
        $(this).parents("li").eq(0).remove();
        //清除缓存
        menu_cache.link[nid] = undefined;
        menu_cache.iframe[nid] = undefined;
    })
})

//更改历史导航位置
function favorite_menu_position(nid) {
    //ul对象
    var ul_obj = $("div.favorite_menu ul");
    var ul_offset = ul_obj.offset();
    var ul_len = 0;
    $("li", ul_obj).each(function (i) {
        ul_len += parseInt($(this).outerWidth());
    })
    var ul_w = ul_obj.width(ul_len + 2);
    //div
    var div_obj = $("div.menu_nav");
    var div_offset = div_obj.offset();
    var div_left = div_offset.left;
    var div_right = div_obj.outerWidth() + div_offset.left;

    //li对象
    var li_obj = $("div.favorite_menu ul li[nid='" + nid + "']");
    var li_offset = li_obj.offset();
    var li_left = li_offset.left;
    var li_right = li_left + li_obj.outerWidth();
    //修改ul宽度
    if (li_right > div_right) {
        var _s = li_right - div_right + 18;
        ul_obj.offset({left: ul_offset.left - _s});
    }
    if (li_left < div_left) {
        var _s = div_left - li_left + 18;
        ul_obj.offset({left: ul_offset.left + _s});
    }
    show_iframe(nid);
}

//历史菜单左、右
$(function () {
    $("div.direction a.left").click(function () {
        //第一个li宽度
        var _li = $("div.favorite_menu li.action").prev();
        //前面没有了
        if (_li.length == 0)return;
        $("div.favorite_menu li").removeClass("action");
        _li.addClass("action");
        favorite_menu_position(_li.attr("nid"));
        show_iframe(_li.attr("nid"));
    })
    $("div.direction a.right").click(function () {
        //第一个li宽度
        var _li = $("div.favorite_menu li.action").next();
        //前面没有了
        if (_li.length == 0)return;
        $("div.favorite_menu li").removeClass("action");
        _li.addClass("action");
        favorite_menu_position(_li.attr("nid"));
        show_iframe(_li.attr("nid"));
    })
})
//双击关闭历史标签
$(function () {
    $("a.menu").live("dblclick", function () {
        $(this).next("a").trigger("click");
    })
})


//＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝更新导航＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
/**
 * 更新导航一级导航（最顶部）
 * @param id 菜单id号
 */
//function update_menu(pid, url) {
//  $.post(WEB + '?a=Menu&c=Menu&m=get_child_menu_id&pid=' + pid, function (sids) {
//      // ids 所有子菜单
//      if (sids.length >= 1) {
//          var win = top || opener;
//          //清除点击顶部菜单后产生的缓存
//          win.menu_cache.parent[pid] = false;
//          //触发顶部导航点击事件
//          win.get_left_menu(pid);
//      }
//      //iframe跳转url
//      if (url) {
//          location.href = url;
//      }
//  }, "JSON");
//}
/**
 * 删除历史导航与iframe
 * @param nid
 */
function del_history_menu(nid) {
    var win = top || opener;
    //删除历史导航
    $(win.document).find("div.favorite_menu").find("li[nid='" + nid + "']").remove();
    //删除iframe
    $(win.document).find('iframe[nid=' + nid + ']').remove();
    //清除iframe缓存信息
    if (win.menu_cache.iframe[nid])
        win.menu_cache.iframe[nid] = false;
}
//＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝更新导航＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝























