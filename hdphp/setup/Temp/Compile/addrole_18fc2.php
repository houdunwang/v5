<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_WARNING",false);?><?php if(!defined("HDPHP_PATH"))exit;C("SHOW_WARNING",false);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>        
        <title>欢迎使用  后盾HD框架安装配置</title>
        <meta http-equiv="content-type" content="text/htm;charset=utf-8"/>  
        <link href='http://localhost/hdphp/setup/Tpl/State/Css/setup.css' rel='stylesheet' type='text/css'/>
        <script type='text/javascript' src='http://localhost/hdphp/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
    </head>

<div class="hd_setup">
    <strong>欢迎使用后盾HD框架，通过HD框架手册或登录<a href="http://bbs.houdunwang.com/">后盾论坛</a>学习使用HD框架安装配置</strong>
    <h2>
        <a href="http://localhost/hdphp/setup/index.php/Rbac/showrole" target="_self">查看用户组(角色)</a>&nbsp;&nbsp;&nbsp;
        <br/>
        <a href="http://localhost/hdphp/setup/index.php/Rbac" class="home">返回安装首页</a>
        <a href="javascript:void(0)"  class="home" onclick="window.close();return false;">关闭</a>
        <a href="http://localhost/hdphp/setup/index.php/rbac/lock" class="home">锁定SETUP应用</a>
    </h2>
</div>
<form method="post" name="form1" id="form1" action="http://localhost/hdphp/setup/index.php/Rbac/addentrance">
    <input type="hidden" name="pid" value="<?php $_emptyVar =isset($_GET['pid'])?$_GET['pid']:null?><?php  if( empty($_emptyVar)){?>0<?php }else{ ?><?php echo $_GET['pid'];?><?php }?>"/>
    <div class="setup">
        <dl>
            <dt>添加用户角色（用户组）</dt>
            <dd>
                <table>
                    <tr><td width="200">角色(组)名称:</td>
                        <td>
                            <input type="text" name="rname" id="rname"/><span>必须为英文字母表示</span>
                        </td>
                    </tr>
                    <tr><td width="200">角色描述:</td>
                        <td>
                            <input type="text" name="title" id="title"/><span>中文文字说明</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="200">是否开启角色</td>
                        <td><input type="radio" name="state" id="state" value="1"  style="width:20px;" checked="checked"/> 开启
                            <input type="radio" name="state" id="state" value="0"  style="width:20px;"/> 关闭</td>
                    </tr>
                    <tr><td width="200"><input type="submit" value="确认" class="query" name="submit"/></td></tr>
                </table>
            </dd>
        </dl>
    </div>
</form>
<script type="text/javascript">
     $("#form1").submit(function(){
        var stat = true;
        $("#rname").next("span").remove();
        if($("#rname").val()==''){
            stat = false;
            $("#rname").after("<span>角色不能为空</span>");
        }else if(!/^[a-z]\w+$/.test($("#rname").val())){
            stat = false;
            $("#rname").after("<span>必须为英文</span>");
        }
        $("#title").next("span").remove();
        if($("#title").val()==''){
            stat = false;
            $("#title").after("<span>角色描述不能为空</span>");
        }else if(!/^[\u4e00-\u9fa5]+$/.test($("#title").val())){
            stat = false;
            $("#title").after("<span>必须为中文</span>");
        }
        if(!stat)return false;
    })
</script>
</body>
</html>
