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
                <li class="current">数据库设定</li>
                <li>生成数据</li>
                <li>安装完成</li>
            </ul>
        </div>
        <!--协议说明-->
        <div class="install">
            <div class="check set">
                <h3>数据库配置</h3>
                <table width="100%">
                    <tr>
                        <td width="200">数据库主机</td>
                        <td><input type="text" class="input" mast_required="1" error="数据库主机地址不能为空" name="DB_HOST"
                                   value="localhost"/>
                            <span class="message">MAC系统请输入127.0.0.1</span></td>
                    </tr>
                    <tr>
                        <td>数据库用户</td>
                        <td><input type="text" class="input" name="DB_USER" mast_required="1" error="数据库用户不能为空"
                                   value="root"/>
                            <span class="message"></span></td>
                    </tr>
                    <tr>
                        <td>数据库密码</td>
                        <td><input type="text" class="input" name="DB_PASSWORD" value=""/>
                            <span class="message"></span></td>
                    </tr>
                    <tr>
                        <td>数据表前缀</td>
                        <td><input type="text" class="input" name="DB_PREFIX" mast_required="1" error="数据表前缀不能为空"
                                   value="hd_"/>
                            <span class="message"></span></td>
                    </tr>
                    <tr>
                        <td>数据库名称</td>
                        <td><input type="text" class="input" name="DB_DATABASE" mast_required="1" error="数据库名称不能为空"
                                   value="hdcms"/>
                            <span class="message"></span></td>
                    </tr>
                </table>
            </div>
            <div class="check set">
                <h3>管理员初始密码</h3>
                <table width="100%">
                    <tr>
                        <td width="200">管理员</td>
                        <td><input type="text" class="input" name="ADMIN" mast_required="1" error="用户名不能为空"
                                   value="admin"/>
                            <span class="message"></span></td>
                    </tr>
                    <tr>
                        <td>密　码</td>
                        <td><input type="text" class="input" name="PASSWORD" mast_required="1" value="admin888" error="密码不能为空"/>
                            <span class="message"></span></td>
                    </tr>
                    <tr>
                        <td>确认密码</td>
                        <td><input type="text" class="input" name="C_PASSWORD" mast_required="1" value="admin888" error="确认密码不能为空"/>
                            <span class="message"></span></td>
                    </tr>
                </table>
            </div>
            <div class="check set">
                <h3>网站设置</h3>
                <table width="100%">
                    <tr>
                        <td width="200">网站名称</td>
                        <td><input type="text" class="input" name="WEBNAME" value="HDCMS内容管理系统" mast_required="1" error="网站名称不能为空"/>
                            <span class="message"></span></td>
                    </tr>
                    <tr>
                        <td>站长邮箱</td>
                        <td><input type="text" class="input" name="EMAIL" mast_required="1" error="站长邮箱不能为空" value=""/>
                            <span class="message"></span></td>
                    </tr>
                </table>
            </div>
            <div class="check set">
                <h3>安装测试体验数据</h3>
                <table width=""
                1"00%">
                <tr>
                    <td width="200">初始化数据体验包</td>
                    <td><input type="checkbox" name="INSERT_TEST_DATA" value="1" checked="checked"/> 安装初始化数据进行体验</td>
                </tr>
                </table>
            </div>
        </div>
        <!--协议说明-->
        <div class="btn">
            <a href="?step=4">上一步</a><a href="javascript:;" id="check_config">下一步</a>
        </div>
    </div>
</body>
</html>