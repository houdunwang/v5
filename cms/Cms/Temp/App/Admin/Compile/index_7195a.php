<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>V5CMS - 后台管理中心</title>
    <link type="text/css" rel="stylesheet" href="http://localhost/v5/cms/Cms/App/Admin/Tpl/Index/css/css.css"/>
    <script type="text/javascript" src="http://localhost/v5/cms/Cms/App/Admin/Tpl/Index/js/js.js"></script>
    <base target='iframe'/>
</head>
<body>
<div class="nav">
    <!--头部左侧导航-->
    <div class="top_menu">
        <a href="javascript:" onclick="get_left_menu(this,0);" class="top_menu">常用</a>
       
    </div>
    <!--头部左侧导航-->
    <!--头部右侧导航-->
    <div class="r_menu">
        <?php echo $_SESSION['username'];?> <a href="<?php echo U('Login/out');?>" target="_self">[退出]</a><span>|</span>
        <a href="http://localhost/v5/cms/index.php" target="_blank">前台首页</a>
    </div>
    <!--头部右侧导航-->
</div>
<!--左侧导航-->
<div class="main">
    <!--主体左侧导航-->
    <div class="left_menu">
        <div>
            <dl>
                <dt>常用</dt>
				<dd>
                    <a  href="<?php echo U('Article/Article/index');?>">文章管理</a>
                </dd>
                <dd>
                    <a  href="<?php echo U('Category/Category/index');?>">栏目管理</a>
                </dd>
            </dl>
            <dl>
                <dt>网站配置</dt>
                <dd>
                    <a  href="<?php echo U('Config/Config/set_config');?>">网站配置</a>
                </dd>
            </dl>
        </div>
    </div>
    <!--主体左侧导航-->
   
    <div class="top_content">
        <iframe src="<?php echo U('welcome');?>"  name='iframe'  scrolling="auto" frameborder="0" style="height: 100%;width: 100%;"></iframe>
    </div>
    <!--内容显示区域-->
</div>
<!--左侧导航-->
</body>
</html>