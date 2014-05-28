//表单验证
$(function () {
    $("form").validate({
    	mid: {
            rule: {
                required: true
            },
            error: {
                required: "请选择模型"
            }
        },
        catname: {
            rule: {
                required: true
            },
            error: {
                required: "栏目名称不能为空"
            },
            message:'栏目名称'
        },
        catdir: {
            rule: {
                required: true,
                ajax:{url:CONTROL+'&m=check_category_dir',field:['cid']}
            },
            error: {
                required: "静态目录不能为空",
                ajax:'目录已经使用'
            },
            message:'请输入静态目录'
        },
        index_tpl: {
            rule: {
                required: true
            },
            error: {
                required: "封面模板不能为空"
            },
            message:'请输入封面模板'
        },
        list_tpl: {
            rule: {
                required: true
            },
            error: {
                required: "列表页模板不能为空"
            },
            message:'请输入列表页模板'
        },
        arc_tpl: {
            rule: {
                required: true
            },
            error: {
                required: "内容页模板不能为空"
            },
            message:'请输入内容页模板'
        },
        cat_html_url: {
            rule: {
                required: true
            },
            error: {
                required: "栏目页URL规则不能为空"
            },
            message:'{cid} 栏目ID, {catdir} 栏目目录, {page} 列表的页码'
        },
        arc_html_url: {
            rule: {
                required: true
            },
            error: {
                required: "内容页URL规则不能为空"
            },
            message:'{y}、{m}、{d} 年月日,{timestamp}UNIX时间戳,{aid} 文章ID,{catdir} 栏目目录'
        },
        add_reward: {
            rule: {
                required: true,
                regexp: /^\d+$/
            },
            error: {
                required: "投稿奖励不能为空",
                regexp: '投稿奖励必须为数字'
            },
            message:'发表文章时获得的奖励积分，为负数时减积分'

        },
        show_credits: {
            rule: {
                required: true,
                regexp: /^\d+$/
            },
            error: {
                required: "阅读积分不能为空",
                regexp: '阅读积分必须为数字'
            },
            message:'查看此栏目下文章的收费标准。如果文章单独设置了查看积分，则以文章设置为准。'

        },
        repeat_charge_day: {
            rule: {
                required: true,
                regexp: /^[1-9]+$/
            },
            error: {
                required: "重复收费天数不能为空",
                regexp: '重复收费天数必须为数字，必须大于1天'
            },
            message:'重复收费天数，必须大于1天。'

        }
    })
})
//获得静态目录(将目录名转为拼音)
$(function () {
    $("[name='catname']").blur(function () {
        //栏目类型不为外部链接时获取
        if ($("[name='cattype']:checked").val() != 3) {
            //栏目名
            $catname = $.trim($("[name='catname']").val())
            //静态目录名
            $catdir = $.trim($("[name='catdir']").val());
            //静态目录名为空时获得
            if (!$catdir && $catname) {
                $.post(CONTROL + "&m=dir_to_pinyin", {catname: $(this).val()}, function (data) {
                    $("[name='catdir']").val(data);
                })
            }
        }
    })
})


/**
 * 权限全选复选框
 * @param type
 */
function select_access_checkbox(obj) {
    var state = !$(obj).attr('selected');
    $(obj).attr('selected', state);
    $(obj).parents('tr').eq(0).find('input').attr('checked', state);
}

/**
 * 更换模板
 * @param input_id
 */
function select_template(name) {
	$.modal({
		title : '选择模板文件',
		button_cancel : '关闭',
		width : 650,
		height : 450,
		content : '<iframe frameborder=0 scrolling="no" style="height:99%;border:none;" src="' + APP + '&c=TemplateSelect&m=select_tpl&name=' + name + '"></iframe>'
	});
}

/**
 * 关闭模板选择窗口
 */
function close_select_template() {
	$.removeModal();
}























