<?php if (!defined("VERSION")) exit; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title><?php echo $step[4]; ?></title>
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
            <li class="current">环境检测</li>
            <li>数据库设定</li>
            <li>生成数据</li>
            <li>安装完成</li>
        </ul>
    </div>
    <!--协议说明-->
    <div class="install">
        <div class="check set">
            <table width="100%">
                <tr>
                    <th width="200">环境检测</th>
                    <th>当前状态</th>
                </tr>
                <tr>
                    <td>服务器域名</td>
                    <td><?php echo $host; ?></td>
                </tr>
                <tr>
                    <td>服务器解译引擎</td>
                    <td><?php echo $server; ?></td>
                </tr>
                <tr>
                    <td>PHP版本</td>
                    <td><?php echo $php_version; ?></td>
                </tr>
                <tr>
                    <td>系统安装目录</td>
                    <td><?php echo WEB_PATH; ?></td>
                </tr>
                </tr>
            </table>
        </div>

        <div class="check set">
            <table width="100%">
                <tr>
                    <th width="200">需开启的变量或函数</th>
                    <th width="100">当前状态</th>
                    <th>说明</th>
                </tr>
                <tr>
                    <td>allow_url_fopen</td>
                    <td><?php echo $allow_url_fopen; ?>
                    <td> <span class="desc">
                        (不符合要求将导致采集、远程资料本地化等功能无法应用)
                    </span></td>
                    </td>
                </tr>
                <tr>
                    <td>safe_mode</td>
                    <td><?php echo $safe; ?></td>
                    <td> <span class="desc">
                        (本系统不支持在非win主机的安全模式下运行)
                    </span></td>
                </tr>
                <tr>
                    <td>GD 库</td>
                    <td><?php echo $gd; ?></td>
                    <td> <span class="desc">
                        (不支持将导致与图片相关的大多数功能无法使用或引发警告)
                    </span></td>
                </tr>
                <tr>
                    <td>MySQLI扩展</td>
                    <td><?php echo $mysqli; ?></td>
                    <td> <span class="desc">
                        (不支持无法使用本系统)
                    </span></td>
                </tr>
                <tr>
                    <td>mb_substr</td>
                    <td><?php echo $mb_substr; ?></td>
                    <td> <span class="desc">
                        (必须存在mbstring扩展库)
                    </span></td>
                </tr>
            </table>
        </div>
        <div class="check set">
            <table width="100%">
                <tr>
                    <th width="200">目录、文件权限检查</th>
                    <th width="100">写入</th>
                    <th>读取</th>
                </tr>
                <?php foreach ($dirctory as $d): ?>
                    <tr>
                        <td><?php echo $d; ?></td>
                        <td><?php echo is_writable('../'.$d) ? '<span class="dir_success">可写</span>' : '<span class="dir_error">不可写</span>'; ?>
                        <td><?php echo is_readable('../'.$d) ? '<span class="dir_success">可读</span>' : '<span class="dir_error">不可读</span>'; ?></td>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>
        </div>
    </div>
    <!--协议说明-->
    <div class="btn">
        <a href="?step=3">上一步</a><a href="?step=5" onclick="return check_dir();">下一步</a>
    </div>
</div>
</body>
</html>