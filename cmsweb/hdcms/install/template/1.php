<?php if (!defined("VERSION")) exit; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title><?php echo $step[1]; ?></title>
    <link type="text/css" href="./template/css/css.css" rel="stylesheet"/>
    <style type="text/css">
        div.info{
            position: absolute;
            width: 800px;
            top:420px;
            text-align: center;
            font-family: '微软雅黑';
        }
        div.info h1{
            font-size:25px;
            font-weight: bold;
        }
        div.info p{
            margin-top:10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="wrap">
    <div class="step1 step" style="height: 550px;">
        <div class="info">
            <h1>
                <?php echo $version['HDCMS_NAME'] . "({$version['HDCMS_VERSION']})"; ?>
            </h1>
            <p>
                若要安装HDCMS请点按“继续”
            </p>
        </div>
        <div class="btn" style="position: absolute;top: 520px;">
            <a href="?step=2" class="btn">继 续</a>
        </div>
    </div>
</div>
</body>
</html>