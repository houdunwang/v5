<!DOCTYPE html>
<html>
<head>
    <title>{$hd.config.webname}</title>
    <link rel="shortcut icon" href="favicon.ico">
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <jquery/>
    <bootstrap/>
    <link rel="stylesheet" type="text/css" href="template/system/Member/Login/css/reg.css?ver=1.0"/>
    <style type="text/css">
    	h1{
    		font-family: "微软雅黑";
    		font-size:22px;
    		color:#666;
    		padding:0px !important;
    		margin:25px 0px ;
    		line-height: 2em;
    	}
    	div.emailmessage{
    		font-size:16px;color:#333;
    		line-height: 2em;
    	}
    	div.emailhelp h3{
    		font-family: "微软雅黑";
    		font-size:14px;
    	}
    	div.emailhelp p{
    		font-size:12px;color:#666;
    	}
    </style>
</head>
<body>
<div class="header container">
    <a href="__ROOT__">
        后盾网 人人做后盾
    </a>
</div>
<div class="content container">
    <article class="row" style="padding-top:0px;">
        <div class="field col-md-8">
            <div id="error_tips" class="alert alert-warning " style="display: none"></div>
            <form class="form-horizontal" role="form" method="post" action="__URL__">
                <h1>{$message}</h1>
                <p>
			  		<a class="btn btn-large btn-success"  href="{|U:'findPassword'}">重新获取</a>
		  			<a class="btn btn-large btn-primary" id="sendBtn" href="{|U:'Login/login'}">重新登录</a>
				</p>
            </form>
        </div>
        <div class="field col-md-4">
           <div class="emailhelp">
                	<h3>没有收到验证邮件?你可以：</h3>
                	<p> >   到邮箱中的垃圾邮件、广告邮件目录中找找</p>
                </div>
        </div>
    </article>
</div>
</body>
</html>