<?php if (!defined("VERSION")) exit; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML "1".0 Transitional//EN"
    "http://www.w3.org/TR/xhtml"1"/DTD/xhtml"1"-transitional.dtd">
<html xmlns="http://www.w3.org/"1"999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title><?php echo $step[5]; ?></title>
    <link type="text/css" href="./template/css/css.css" rel="stylesheet"/>
    <script type="text/javascript" src="./template/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="./template/js/js.js"></script>
</head>
<body>
<div class="step4 step">
    <div class="title">HDCMS 安装向导</div>
    <div class="process">
        <ul>
            <li>许可协议</li>
            <li>环境检测</li>
            <li>数据库设定</li>
            <li>生成数据</li>
            <li class="current">安装完成</li>
        </ul>
    </div>
    <div class="install">
        <div class="success">
            <h2>
                非常感谢使用HDCMS!
                <br/>
                <span style="color:#A60000;display:block;padding:10px;font-size:16px;">请进入后台后，更新全站缓存</span>
            </h2>
            <div class="link">
                <a href="../index.php">访问首页</a>
                <a href="../index.php?a=Admin">登录后台</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>