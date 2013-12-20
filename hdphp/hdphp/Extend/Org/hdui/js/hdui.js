// ====================================================================================
// ===================================--|函数库|--======================================
// ====================================================================================
// .-----------------------------------------------------------------------------------
// |  Software: [HDJS framework]
// |   Version: 2013.08
// |      Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// |    Author: 后盾网向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://www.houdunwang.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
// |   License: http://www.apache.org/licenses/LICENSE-2.0
// '-----------------------------------------------------------------------------------
//去除超链接虚线
$(function () {
    $("a").click(function () {
        $(this).trigger("blur")
    });
})
//新窗口打开链接
function _open(url) {
    window.open(url, "");
}
//关闭窗口
function _close(msg) {
    if (msg) {
        if (!confirm(msg))return;
    }
    window.close()
}
/**
 * 获得对象在页面中心的位置
 * @author hdxj
 * @category functions
 * @param obj 对象
 * @returns {Array} 坐标
 */
function center_pos(obj) {
    var pos = [];//位置
    pos[0] = ($(window).width() - obj.width()) / 2
    pos[1] = $(window).scrollTop() + ($(window).height() - obj.height()) / 2
    return pos
}
// ====================================================================================
// =====================================--|UI|--=======================================
// ====================================================================================
// .-----------------------------------------------------------------------------------
// |  Software: [HDJS framework]
// |   Version: 2013.08
// |      Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// |    Author: 向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://www.houdunwang.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
// |   License: http://www.apache.org/licenses/LICENSE-2.0
// '-----------------------------------------------------------------------------------
/**
 * tab面板使用
 * @author hdxj
 * @category ui
 */
$(function () {
    //首页加载显示第一1个
    var index = $("div.tab ul.tab_menu li a").index($("a.action:gt(0)"));
    index = index > 0 ? index : 0;
    $("div.tab ul.tab_menu li a").removeClass("action");
    $("div.tab ul.tab_menu li:eq(" + index + ") a").addClass("action");
    $("div.tab div.tab_content").children("div").eq(index).addClass("action");
    $("div.tab_content").children("div").addClass("hd_tab_content_div");
    //点击切换
    $("div.tab ul.tab_menu li").click(function () {
        //改变标题 如果是链接，直接跳转
        if (/^http/i.test($(this).find("a").attr("href"))) {
            return true;
        }
        $("div.tab ul.tab_menu li a").removeClass("action");
        $("a", this).addClass("action");
        var _id = $(this).attr("lab");
        $("div.tab_content div").removeClass("action");
        $("div.tab_content div#" + _id).addClass("action");
    })
})
/**
 * dialog对话框
 */
$.extend({
    "dialog": function (options) {
        var _default = {
            "type": "success"//类型 CSS样式
            , "msg": "msg属性配置错误"//提示信息
            , "timeout": 2//自动关闭时间
            , "close_handler": function () {
            }//关闭时的回调函数
        };
        var opt = $.extend(_default, options);
        //创建元素
        if ($("div.dialog").length == 0) {
            var div = '';
            div += '<div class="dialog" style="z-index: 1000;position: absolute">';
            div += '<div class="close">';
            div += '<a href="#" title="关闭">×</a></div>';
            div += '<h2 id="dialog_title">提示信息</h2>';
            div += '<div class="con ' + opt.type + '"><strong>ico</strong>';
            div += '<span>' + opt.msg + '</span>';
            div += '</div>';
            div += '</div>';
            div += '<div class="dialog_bg" style="background: #f3f3f3;position:absolute;left:0px;top:0px;z-index: 100;"></div>'
            $(div).appendTo("body");
        }
        var _w = $(document).width();
        var _h = $(document).height();
        $("div.dialog_bg").css({width: _w, height: _h, opacity: 0.8}).show();
        $("div.dialog").show();
        var pos = center_pos($(".dialog"));
        $("div.dialog").css({left: pos[0], top: pos[1] - 50});
        //定时id
        var dialog_id;
        //点击关闭dialog
        $("div.dialog div.close a").click(function () {
            opt.close_handler();
            $("div.dialog_bg").remove();
            $("div.dialog").remove();
            clearTimeout(dialog_id);
        })
        //自动关闭
        dialog_id = setTimeout(function () {
            //如果dialog已经关闭，不执行事件
            if ($("div.dialog").length == 0)return;
            opt.close_handler();
            $("div.dialog_bg").remove();
            $("div.dialog").remove();
        }, opt.timeout * 500);
    }
})
//简单提示框
function dialog_message(message, dialog_close) {
    $("div#hd_message").remove();
    $("div#hd_message_bg").remove();
    if (dialog_close) {
        return false;
    } else {
        //创建背景色
        var html = '<div id="hd_message_bg" style="background: #f3f3f3;position:absolute;left:0px;top:0px;z-index: 100;"></div>';
        html += "<div id='hd_message' style='display:none;position: absolute;z-index: 1000'>" + message + "</div>";
        $("body").append(html);
        //改变背景色
        var _w = $(document).width();
        var _h = $(document).height();
        $("div#hd_message_bg").css({width: _w, height: _h, opacity: 0.9}).show();
        //显示文字
        var pos = center_pos($("#hd_message"));
        $("#hd_message").css({left: pos[0], top: pos[1]}).show();

    }
}
/**
 * 模态对话框
 * @category ui
 */
$.extend({
    "modal": function (options) {
        var _default = {
            title: '', content: false, width: 650, button: true,
            send_title: "确定",
            cancel_title: "关闭",
            message: false,
            type: "success",
            cancel: false,//事件
            send: false,//事件
            show: true//是否显示
        };
        var opt = $.extend(_default, options);
        //删除所有弹出框
        $("div.modal").remove();
        var div = '';
        var show = opt.show ? "" : ";display:none;"
        div += '<div class="modal" style="position:absolute;left:50%;top:50%;margin-top:-' + (opt['height'] / 2 + 150) + 'px;margin-left:-' + (opt['width'] / 2) + 'px;width:' + opt['width'] + 'px;' + show + 'height:' + opt['height'] + 'px;z-index:1000">';
        if (opt['title']) {
            div += '<div class="modal_title">' + opt['title'] + '</div>';
        }
        var con_h = opt['height'] - (opt['title'] ? 35 : 0) - (opt.button ? 55 : 0);
        div += '<div class="content" style="height:' + (con_h) + 'px;">';
        if (opt.message) {
            div += '<div class="modal_message"><strong class="' + opt.type + '"></strong><span>' + opt.message + '</span></div>';
        } else {
            div += opt.content;
        }
        div += '</div>';
        if (opt.button) {
            div += '<div class="modal_footer" ' + (opt.message ? 'style="text-align:center"' : "") + '>';
            div += '<a href="javascript:;" class="btn btn-primary hd_success">' + opt.send_title + '</a>';
            if (opt.cancel_title)
                div += '<a href="javascript:;" class="btn hd_close">' + opt.cancel_title + '</a>';
            div += '</div>';
        }
        div += '</div>';
        div += '<div class="modal_bg" style="background: #f3f3f3;position:absolute;left:0px;display:none;top:0px;z-index: 900;"></div>';
        $(div).appendTo("body");
        var pos = center_pos($(".modal"));
        //点击确定
        $("div.modal_footer a.hd_success").click(function () {
            if (opt.send) {
                opt.send();
            } else {
                $("div.modal_footer a.hd_close").trigger("click");
            }
        })
        var _w = $(document).width();
        var _h = $(document).height();
        $("div.modal_bg").css({width: _w, height: _h, opacity: 0.6});
        if (opt.show) {
            $("div.modal_bg").show();
        }
        //点击关闭modal
        if (opt.cancel) {
            $("div.modal_footer a.hd_close").live("click", opt.cancel);
        } else {
            $("div.modal_footer a.hd_close").bind("click", function () {
                $(this).parents("div.modal").eq(0).fadeOut(function () {
                    $(this).parents("div.modal").eq(0).remove();
                });
                $("div.modal_bg").remove();
                return false;
            })
        }
    }
});
// ====================================================================================
// ===================================--|表单验证|--=====================================
// ====================================================================================
// .-----------------------------------------------------------------------------------
// |  Software: [HDJS framework]
// |   Version: 2013.08
// |      Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// |    Author: 后盾网向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://www.houdunwang.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
// |   License: http://www.apache.org/licenses/LICENSE-2.0
// '-----------------------------------------------------------------------------------
/**
 * 表单验证
 * @category validation
 */

$.fn.extend({
    validation: function (options) {
        //缓存数据
        $(this).data("validation", options);
        //验证规则
        var method = {
            "ajax": function (data) {
                var stat = true;
                //内容不为空时验证
                if (data.obj.val()) {
                    //默认为失败，Ajax后再处理
                    data.obj.attr("validation", 0);
                    //清除提示信息span
                    data.spanObj.removeClass("success").removeClass("error").html("");
                    var stat = true;
                    //内容不为空时验证
                    if (data.obj.val()) {
                        //异步提交的参数值
                        var requestData = options[data.name].rule["ajax"];//异步请求的url
                        var param = {};//异步传参
                        var url = "";//请求的Url
                        if (typeof requestData == 'object') {//传参为对象
                            url = requestData.url;//请求Url
                            param[data.name] = data.obj.val();
                            //附加请求参数
                            if (requestData['data']) {
                                for (var i in requestData['data']) {
                                    param[i] = requestData['data'][i];
                                }
                            }
                            //附附加字段，有field属性
                            if (requestData['field']) {
                                for (var i = 0; i < requestData['field'].length; i++) {
                                    var name = requestData['field'][i];
                                    param[name] = $("[name='" + name + "']").val();
                                }
                            }
                        } else {//传参不为对象
                            url = requestData;
                            param[data.name] = data.obj.val();
                        }
                        //发送异步
                        $.post(url, param, function (result) {
                            //成功时，如果是提交暂停状态则再次提交
                            if (result == 1) {
                                //移除表单属性validation
                                data.obj.removeAttr("validation");
                                //验证结果处理，提示信息等
                                method.call_handler(1, data);
                                //如果是通过submit调用，则提交
                                if (data.send && $("[validation='0']").length == 0) {
                                    options.form.trigger("submit", ['send']);
                                }
                            } else {
                                method.call_handler(0, data);
                            }
                        });
                        //验证结果处理，提示信息等
                    }
                }
                return stat;
            },
            //比较两个表单
            "confirm": function (data) {
                var field = $("[name='" + options[data.name].rule["confirm"] + "']");
                var stat = true;
                //内容不为空时验证
                if (field.val()) {
                    //比较表单内容是否相等
                    stat = data.obj.val() == field.val();
                    //验证结果处理，提示信息等
                    method.call_handler(stat, data);
                }
                return stat;
            },
            //数字
            "num": function (data) {
                var stat = true;
                //内容不为空时验证
                if (data.obj.val()) {
                    var opt = options[data.name].rule["num"].split(/\s*,\s*/);
                    var val = data.obj.val() * 1;
                    //验证表单
                    stat = val >= opt[0] * 1 && val <= opt[1] * 1;
                    //验证结果处理，提示信息等
                    method.call_handler(stat, data);
                }
                return stat;
            },
            //验证手机
            "phone": function (data) {
                var stat = true;
                //内容不为空时验证
                if (data.obj.val()) {
                    //验证表单
                    stat = /^\d{11}$/.test(data.obj.val());
                    //验证结果处理，提示信息等
                    method.call_handler(stat, data);
                }
                return stat;
            },
            //QQ号
            "qq": function (data) {
                var stat = true;
                //内容不为空时验证
                if (data.obj.val()) {
                    //验证表单
                    stat = /^\d{5,10}$/.test(data.obj.val());
                    //验证结果处理，提示信息等
                    method.call_handler(stat, data);
                }
                return stat;
            },
            //验证固定电话
            "tel": function (data) {
                var stat = true;
                //内容不为空时验证
                if (data.obj.val()) {
                    //验证表单
                    stat = /(?:\(\d{3,4}\)|\d{3,4}-?)\d{8}/.test(data.obj.val());
                    //验证结果处理，提示信息等
                    method.call_handler(stat, data);
                }
                return stat;
            },
            //验证身份证
            "identity": function (data) {
                var stat = true;
                //内容不为空时验证
                if (data.obj.val()) {
                    //验证表单
                    stat = /^(\d{15}|\d{18})$/.test(data.obj.val());
                    //验证结果处理，提示信息等
                    method.call_handler(stat, data);
                }
                return stat;
            },
            //网址
            "http": function (data) {
                var stat = true;
                //内容不为空时验证
                if (data.obj.val()) {
                    //验证表单
                    stat = /^(http[s]?:)?(\/{2})?([a-z0-9]+\.)?[a-z0-9]+(\.(com|cn|cc|org|net|com.cn))$/i.test(data.obj.val());
                    //验证结果处理，提示信息等
                    method.call_handler(stat, data);
                }
                return stat;
            },
            //中文
            "china": function (data) {
                var stat = true;
                //内容不为空时验证
                if (data.obj.val()) {
                    //验证表单
                    stat = /^([^u4e00-u9fa5]|\w)+$/i.test(data.obj.val());
                    //验证结果处理，提示信息等
                    method.call_handler(stat, data);
                }
                return stat;
            },
            //最小长度
            "minlen": function (data) {
                var stat = true;
                //内容不为空时验证
                if (data.obj.val()) {
                    //验证表单
                    stat = data.obj.val().length >= options[data.name].rule["minlen"];
                    //验证结果处理，提示信息等
                    method.call_handler(stat, data);
                }
                return stat;
            },
            //最大长度
            "maxlen": function (data) {
                var stat = true;
                //内容不为空时验证
                if (data.obj.val()) {
                    //验证表单
                    stat = data.obj.val().length <= options[data.name].rule["maxlen"];
                    //验证结果处理，提示信息等
                    method.call_handler(stat, data);
                }
                return stat;
            },
            //正则验证处理
            "regexp": function (data) {
                var stat = true;
                if (data.obj.val()) {
                    //是否正则对象
                    if (options[data.name].rule["regexp"] instanceof  RegExp) {
                        //是否必须验证
                        var reg = options[data.name].rule["regexp"];
                        stat = reg.test(data.obj.val());
                        //验证结果处理，提示信息等
                        method.call_handler(stat, data);
                    }
                }
                return stat;
            },
            //验证邮箱
            "email": function (data) {
                var stat = true;
                //内容不为空时验证
                if (data.obj.val()) {
                    //验证表单
                    stat = /^([a-zA-Z0-9_\-\.])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/i.test(data.obj.val());
                    //验证结果处理，提示信息等
                    method.call_handler(stat, data);
                }
                return stat;
            },
            //验证用户名
            "user": function (data) {
                var stat = true;
                if (data.obj.val()) {
                    //user: "6,20"  opt为拆分"6,20"
                    var opt = options[data.name].rule["user"].split(/\s*,\s*/);
                    var reg = new RegExp("^[a-z]\\\w{" + (opt[0] - 1) + "," + (opt[1] - 1) + "}$", "i");
                    //验证表单
                    stat = reg.test(data.obj.val());
                    //验证结果处理，提示信息等
                    method.call_handler(stat, data);
                }
                return stat;
            },
            //验证表单是否必须添写
            "required": function (data) {
                var required = options[data.name].rule["required"];
                var stat = true;
                var objType = data.obj.attr("type") && data.obj.attr("type").toLowerCase();
                //是否必须验证
                if (required) {
                    //不为空
                    stat = $.trim(data.obj.val()) != "";
                    //验证结果处理，提示信息等
                    method.call_handler(stat, data);
                } else if (data.obj.val() == '') {//非必填项，当表单内容为空时，清除提示信息
                    method.call_handler(true, data);
                }
                return stat;
            },
            //调用事件处理程序
            call_handler: function (stat, data) {
                var name = data.name;//元素的ID值
                var obj = data.obj;//表单对象
                var rule = data.rule;//规则
                var spanObj = data.spanObj;//提示信息表单
                $(data.spanObj).removeClass("error success").addClass("validation").html("");
                $(obj).removeClass("input_error");
                if (stat) {//验证通过
                    //添加表单属性validation
                    obj.removeAttr("validation");
                    //设置正确提示信息a
                    var msg = (options[data.name].success || options[data.name].message);
                    if (options[data.name].success) {
                        $(data.spanObj).addClass("success").html(msg);
                    } else {
                        $(data.spanObj).html(msg);
                    }
                } else {//验证失败
                    obj.attr("validation", 0);//添加表单属性validation
                    //设置错误提示信息
                    var msg = (options[data.name].error[data.rule] || "输入错误");
                    $(obj).addClass("input_error");
                    $(data.spanObj).addClass("error");
                    $(data.spanObj).html(msg);
                }

            },
            /**
             * 添加验证设置
             * @param name 表单名
             * @param spanObj 提示信息span
             */
            set: function (name, spanObj) {
                //获得span提示信息表单
                var obj = method.getSpanElement(name);
                var fieldObj = obj[0];
                var spanObj = obj[1];
                options.field.push(fieldObj);
                //获得焦点时设置默认值
                fieldObj.live("focus", function (event, send) {
                    var msg = options[name].message || "";
                    spanObj.removeClass('error success').html(msg);
                })
                //必须验证字段加validation属性
                if (options[name].rule.required) {
                    fieldObj.attr("validation", 0);
                }
                //设置默认提示信息
                method.setDefaultMessage(name, spanObj);
                //确认密码加属性confirm
                if(options[name]['rule']['confirm']){
                    $(fieldObj).attr("confirm",1);
                }
                fieldObj.live("blur", function (event, send) {
                    //没有设置required必须验证时，默认为不用验证
                    options[name].rule.required || (options[name].rule.required = false);
                    for (var rule in options[name].rule) {
                        //验证方法存在
                        if (method[rule]) {
                            /**
                             * 验证失败 终止验证
                             * 参数说明：
                             * name 表单name属性
                             * obj 表单对象
                             * rule 规则的具体值
                             * send 是否为submit激活的
                             */
                            if (!method[rule]({name: name, obj: fieldObj, rule: rule, spanObj: spanObj, send: send}))break;
                        }
                    }
                });
            },
            /**
             * 设置默认提示信息
             * @param name 表单名
             * @param spanObj 提示信息span
             */
            setDefaultMessage: function (name, spanObj) {
                var defaultMessage = options[name].message;
                if (defaultMessage) {
                    spanObj.html(defaultMessage);
                }
            },

            //获得span提示信息表单
            getSpanElement: function (name) {
                var fieldObj = $("[name='" + name + "']");
                var spanId = "hd_" + name;//span提示信息表单的id
                if ($("#" + spanId).length == 0) {
                    fieldObj.after("<span id='" + spanId + "' class='validation'></span>");
                } else {//如果span已经存在，添加validation类
                    $("#" + spanId).removeClass("validation").addClass("validation");
                }
                spanObj = $("#" + spanId);
                return [fieldObj, spanObj];
            }
        };
        //当前操作的form表单
        options.form = $(this);
        options.field = [];
        //处理事件
        for (var name in options) {
            if (name != 'field' && name != 'form') {
                //验证表单规则
                method.set(name);
            }
        }


        /**
         * 提交验证
         * action
         */
        $(this).bind("submit", function (event, action) {
            var obj = $(this).find("[validation='0']");
            if (obj.length > 0) {
                obj.each(function (i) {
                    $(this).trigger("blur", ['submit']);
                    $(this).trigger("change", ['submit']);
                })
                var obj = $(this).find("[validation='0']");
                return obj.length == 0;
            }
            return true;
        })
    },
    //验证表单
    is_validation: function () {
        $(this).find("[validation='0'],[confirm]").trigger("blur");
        if ($(this).find("*[validation='0']").length > 0) {
            return false;
        }
        return true;
    }
});

/**
 * 笛卡儿积组合
 * @param object list 对象
 * @returns {*}
 * <code>
 * var result = descartes({'a':['a','b'],'b':[1,2]});
 * 或
 * var result = descartes(['a','b'],[1,2]);
 * alert(result);//result就是笛卡尔积
 * </code>
 */
function descarte(list) {
    //parent上一级索引;count指针计数
    var point = {};
    var result = [];
    var pIndex = null;
    var tempCount = 0;
    var temp = [];
    //根据参数列生成指针对象
    for (var index in list) {
        if (typeof list[index] == 'object') {
            point[index] = {'parent': pIndex, 'count': 0}
            pIndex = index;
        }
    }
    //单维度数据结构直接返回
    if (pIndex == null) {
        return list;
    }

    //动态生成笛卡尔积
    while (true) {
        for (var index in list) {
            tempCount = point[index]['count'];
            temp.push(list[index][tempCount]);
        }
        //压入结果数组
        result.push(temp);
        temp = [];
        //检查指针最大值问题
        while (true) {
            if (point[index]['count'] + 1 >= list[index].length) {
                point[index]['count'] = 0;
                pIndex = point[index]['parent'];
                if (pIndex == null) {
                    return result;
                }
                //赋值parent进行再次检查
                index = pIndex;
            }
            else {
                point[index]['count']++;
                break;
            }
        }
    }
}
/**
 * jQuery增强函数
 */
jQuery.extend({
    //过小空数组
    "array_filter": function (arr) {
        return $.grep(arr, function (n, i) {
            if ($.trim(n)) {
                return true;
            }
        })
    }
})



























