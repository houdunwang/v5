/**
 * 图片轮换
 <script>
 $(function () {
        $('#flash').slide({
            width: 278,
            height: 215,
            timeout: 3,
            bgcolor:'#f00f00'
        });
    })
 </script>
 <div id="flash">
 <a href="http://www.hdphp.com" title="后盾网 人人做后盾"><img src="__ROOT__/upload/1.jpg" width="278" height="185"/></a>
 <a href="http://www.hdphp.com" title="HDJS 前端开发利器"><img src="__ROOT__/upload/2.jpg" width="278" height="185"/></a>
 </div>
 */
$.fn.extend({
    slide: function (options) {
        //所有a标签
        options.alink = $(this).find("a");
        //图片数量
        options.num = options.alink.length;
        //设置div高度，宽度 定位
        $(this).css({width: options.width, height: options.height, overflow: "hidden", position: "relative"});
        //隐藏所有a
        options.alink.hide();
        //第一个显示
        options.alink.eq(0).show();
        //文字背景颜色
        _bgcolor = options.bgcolor?options.bgcolor:'#333'
        //文字背景div
        var slideText = "<div id='_slideText' style='height: 30px;background:"+_bgcolor+";color:#fff;position: absolute;left: 0px;right: 0px;bottom: 0px;'></div>";
        $(this).append(slideText);
        $("#_slideText").css({opacity: "0.5"});
        //数字
        var slideNum = "<div id='_slideNum' style='position: absolute;height: 18px;bottom: 6px;right: 0px;'>";
        for (var i = 1; i <= options.num; i++) {
            slideNum += "<li style='float: left;opacity:0.8;cursor:pointer;color:#333;width: 18px;height: 18px;background: #fff;margin-right: 6px;text-align: center;line-height: 1.5em;'>" + i + "</li>"
        }
        slideNum += "</div>";
        $(this).append(slideNum);
        //执行动画
        var startIndex = 0;
        setInterval(_run, options.timeout * 1000);
        _run(0);
        function _run(i) {
            startIndex = i != undefined ? i : startIndex;
            //当前a标签
            var _cur = options.alink.eq(startIndex);
            _cur.show();
            //隐藏其他a标签
            options.alink.not(_cur).hide();
            //改变文字
            var _text = options.alink.eq(startIndex).attr("title");
            $("#_slideText").html("<div style='font-size:12px;line-height: 30px;text-indent: 10px;'>" + _text + "</div>");
            //改变数字div
            $("#_slideNum li").css({background: "#fff", color: "#333",'list-style':'none','font-size':'12px'});
            $("#_slideNum li").eq(startIndex).css({background: "#4085AC", color: "#fff"})
            startIndex = startIndex+1 >= options.num ? 0 : startIndex + 1;
        }
        //为数字加事件
        $("#_slideNum li").mouseover(function () {
            var i = $(this).index();
            _run(i);
        })
    }
})