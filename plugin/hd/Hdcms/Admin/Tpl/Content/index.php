<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>内容管理</title>
    <hdjs/>
    <link rel="stylesheet" href="__CONTROL_TPL__/ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <script type="text/javascript" src="__CONTROL_TPL__/ztree/js/jquery.ztree.all-3.5.min.js"></script>
    <base target="content"/>
    <style type="text/css">
    div#tree_title a{
    	color:#333;
    }
    	/*左侧栏目*/
div#category_tree {
    width: 190px;
    position: absolute;
    top: 0px;
    bottom: 0px;
    left: 0px;
    overflow-x: hidden;
    overflow-y: auto;
    border-right: solid 1px #DDDDDD;
}

div#move {
    width: 5px;
    background: #EEEEEE;
    position: absolute;
    left: 191px;
    top: 0px;
    bottom: 0px;
    border-right: solid 1px #DDDDDD;
    cursor: pointer;
}

div#move span {
    font-size: 16px;
    color: #999;
    display: block;
    height: 15px;
    width: 15px;
    position: absolute;
    top:50%;
    margin-top: -15px;
    z-index: 1000;
}
div#move span.left{
    background: url("__CONTROL_TPL__/img/ico_left.gif") no-repeat;
    left: -10px;
}
div#move span.right{
    background: url("__CONTROL_TPL__/img/ico_right.gif") no-repeat;
    left: 5px;
}
/*右侧内容显示区*/
div#content {
    position: fixed;
    left: 197px;
    right: 0px;
    bottom: 0px;
    top: 0px;
}

#tree_title {
    position: absolute;
    top: 10px;
    left: 10px;
}

#tree_title span {
    display: block;
    background: url("__CONTROL_TPL__/ztree/css/zTreeStyle/img/diy/1_open.png");
    width: 15px;
    height: 15px;
    float: left;
    margin-right: 5px;
}
    </style>
</head>
<body>
<div class="wrap">
    <div id="category_tree">
        <div id="tree_title">
            <span></span>
            <a href="javascript:;" onclick="get_category_tree();">刷新栏目</a>
        </div>
        <ul id="treeDemo" class="ztree" style="top:25px;position: absolute;"></ul>
    </div>
    <div id="move">
        <span class="left"></span>
    </div>
    <div id="content">
        <iframe src="{|U:'welcome'}" name="content" scrolling="auto" frameborder="0" style="height:100%;width: 100%;"></iframe>
    </div>
</div>
<script type="text/javascript" charset="utf-8">
	//显示左侧栏目列表TREE
function get_category_tree() {
    $.post(CONTROL + '&m=ajaxCategoryZtree', function (data) {
        var setting = {
            data: {
                simpleData: {
                    enable: true
                }
            }
        };
        var zNodes = data;
        $(document).ready(function () {
            $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        });
    }, 'json');
}
get_category_tree();
//======================点击move标签DIV时改变div布局===============
$(function(){
    $("div#move").toggle(function(){
        $("div#category_tree").stop().animate({
            left:'-200px'
        },500);
        $(this).find('span').attr('class','right').end().stop().animate({
            left:'0px'
        },500);
        $('div#content').stop().animate({
            left:'20px'
        },500);
    },function(){
        $("div#category_tree").stop().animate({
            left:'0px'
        },500);
        $(this).find('span').attr('class','left').end().stop().animate({
            left:'191px'
        },500);
        $('div#content').stop().animate({
            left:'197px'
        },500);
    })
})
</script>
</body>
</html>