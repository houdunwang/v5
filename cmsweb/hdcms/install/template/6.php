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
            <li class="current">生成数据</li>
            <li>安装完成</li>
        </ul>
    </div>
    <div class="install">
        <div class="create_data" id="create_data">
            <iframe src="index.php?step=install" id="insert_data"></iframe>
        </div>
    </div>
</div>
</body>
</html>