<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_WARNING",false);?><?php if(!defined("HDPHP_PATH"))exit;C("SHOW_WARNING",false);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>        
        <title>欢迎使用  后盾HD框架安装配置</title>
        <meta http-equiv="content-type" content="text/htm;charset=utf-8"/>  
        <link href='http://localhost/hdphp/setup/Tpl/State/Css/setup.css' rel='stylesheet' type='text/css'/>
        <script type='text/javascript' src='http://localhost/hdphp/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
    </head>

<body>
    <div class="hd_setup">
        <strong>欢迎使用后盾HD框架，通过HD框架手册或登录<a href="http://bbs.houdunwang.com/">后盾论坛</a>学习使用HD框架安装配置</strong>
        <h2>
        <a href="http://localhost/hdphp/setup/index.php/Rbac" class="home">返回安装首页</a>
        <a href="javascript:void(0)"  class="home" onclick="window.close();return false;">关闭</a>
        <a href="http://localhost/hdphp/setup/index.php/rbac/lock" class="home">锁定SETUP应用</a>
        </h2>
    </div>
    <?php
    $config = C();
    ?>
    <form method="post" name="form1" id="form1" action="http://localhost/hdphp/setup/index.php/Rbac/updateconfig">
        <div class="setup">
            <dl>
                <dt>配置数据库</dt>
                <dd>
                    <table>
                        <tr>
                            <td width="200">数据库连接主机<b>*</b></td>
                            <td><input type="text" value="<?php echo $config['db_host'];?>" name="dbhost" id="dbhost"/></td>
                        </tr>
                        <tr>
                            <td width="200">数据库连接端口</td>
                            <td><input type="text" name="dbport" id="dbport" value="<?php echo $config['db_port'];?>"/></td>
                        </tr>
                        <tr>
                            <td width="200">数据库用户名<b>*</b></td>
                            <td><input type="text" name="dbuser" id="dbuser" value="<?php echo $config['db_user'];?>"/></td></tr>
                        <tr>
                            <td width="200">数据库密码</td>
                            <td><input type="text" name="dbpwd" id="dbpwd" value="<?php echo $config['db_password'];?>"/></td>
                        </tr>
                        <tr>
                            <td width="200">数据库名称<b>*</b></td>
                            <td><input type="text" name="dbname" id="dbname" value="<?php echo $config['db_database'];?>"/></td>
                        </tr>
                        <tr>
                            <td width="200">表前缀</td>
                            <td><input type="text" name="dbfix" id="tbfix" value="<?php echo $config['db_prefix'];?>"/></td>
                        </tr>
                        <tr>
                            <td  colspan="2">
                                <input type="submit" name="submit" value="开始将数据库配置写入文件"   class="query"/>
                            </td>
                        </tr>
                    </table>
                </dd>
        </div>
    </form>
    <script>
        $("#form1").submit(function(){
            var stat = true;
            $("#dbhost").next("span").remove();
            if($("#dbhost").val()==''){
                stat=false;
                $("#dbhost").after("<span>数据库主机不能为空</span>");

            }
            $("#dbuser").next("span").remove();
            if($("#dbuser").val()==''){
                stat=false;
                $("#dbuser").after("<span>数据库用户名不能为空</span>");
            }
            $("#dbname").next("span").remove();
            if($("#dbname").val()==''){
                stat=false;
                $("#dbname").after("<span>数据库名不能为空</span>");
            }
            if(!stat)return false;
        })
    </script>
</body>
</html>



