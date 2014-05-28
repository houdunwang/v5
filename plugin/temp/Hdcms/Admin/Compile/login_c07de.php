<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>HDCMS后台登录</title>
    <script type='text/javascript' src='http://localhost/v5/plugin/hd/HDPHP/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/plugin';
		WEB = 'http://localhost/v5/plugin/index.php';
		URL = 'http://localhost/v5/plugin/index.php?a=Admin&c=Login&m=login';
		HDPHP = 'http://localhost/v5/plugin/hd/HDPHP/hdphp';
		HDPHPDATA = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Extend';
		APP = 'http://localhost/v5/plugin/index.php?a=Admin';
		CONTROL = 'http://localhost/v5/plugin/index.php?a=Admin&c=Login';
		METH = 'http://localhost/v5/plugin/index.php?a=Admin&c=Login&m=login';
		GROUP = 'http://localhost/v5/plugin/hd';
		TPL = 'http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl';
		CONTROLTPL = 'http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Login';
		STATIC = 'http://localhost/v5/plugin/Static';
		PUBLIC = 'http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Public';
		HISTORY = 'http://localhost/v5/plugin/index.php?a=Admin';
		HTTPREFERER = 'http://localhost/v5/plugin/index.php?a=Admin';
</script>
    <link type="text/css" rel="stylesheet" href="http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Login/css/css.css"/>
    <script>
        $(function () {
            var error = '<?php echo $error;?>';
            if (error) {
                $("div#error_tips").show();
                $(".err_m").html(error);
                setTimeout(function(){ $("div#error_tips").hide()},5000);
            }
        })
    </script>
    <script type="text/javascript" src="http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Login/Js/js.js"></script>
</head>
<body>
<div class="header">
    <div class="links">
        <a href="http://localhost/v5/plugin/index.php">首页</a> |
        <a href="http://www.houdunwang.com">PHP实战培训</a> |
        <a href="http://www.hdphp.com">HDCMS官网</a>
        
    </div>
</div>
<div class="main">
    <div class="pics">
    </div>
    <div class="login">
        <div class="title">
            后台登录
        </div>
        <div id="tips" class="tips"></div>
        <div class="web_login">
            <div class="login_form">
                <div id="error_tips">
                    <span class="error_logo"></span>
                    <span class="err_m">12dssfd</span>
                </div>
                <form action="<?php echo U('login');?>" method="post" class="hd-form">
                    <div class="input">
                        <div class="inputOuter">
                            <input type="text" name="username" value="帐号" autofocus='true' placeholder="帐号"
                                   required=""/>
                        </div>
                    </div>
                    <div class="input">
                        <div class="inputOuter">
                            <input type="password" name="password" placeholder="密码" required=""/>
                        </div>
                    </div>
                    <div class="input">
                        <div class="inputOuter">
                            <input type="text" name="code" placeholder="验证码" required=""/>
                        </div>
                    </div>

                    <div class="verifyimgArea">
                        <img src="<?php echo U('code');?>" class="code" style="cursor: pointer;float:left;"
                             onclick="this.src='<?php echo U('code');?>&'+Math.random()"/>
                        <a href="javascript:void(0);" onclick="$('.code').trigger('click')">看不清，换一张</a>
                    </div>
                    <div class="send">
                        <input type="submit" class="btn2" value="登录"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<iframe name="checkLogin" style="display:none;"></iframe>
</body>
</html>