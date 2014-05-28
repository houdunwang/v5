<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>友情链接-<?php echo C("webname");?></title>
    <meta name="keywords" content="<?php echo C("keyworkds");?>">
    <meta name="description" content="<?php echo C("description");?>">
    <link href="http://localhost/v5/plugin/hd/Plugin/Link/Tpl/Index/css/style.css" rel="stylesheet" type="text/css">
    <link href="http://localhost/v5/plugin/hd/Plugin/Link/Tpl/Index/css/about.css" rel="stylesheet" type="text/css">
    <script type='text/javascript' src='http://localhost/v5/plugin/hd/HDPHP/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/plugin';
		WEB = 'http://localhost/v5/plugin/index.php';
		URL = 'http://localhost/v5/plugin/index.php?g=Plugin&a=Link';
		HDPHP = 'http://localhost/v5/plugin/hd/HDPHP/hdphp';
		HDPHPDATA = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Extend';
		APP = 'http://localhost/v5/plugin/index.php?a=Link';
		CONTROL = 'http://localhost/v5/plugin/index.php?a=Link&c=Index';
		METH = 'http://localhost/v5/plugin/index.php?a=Link&c=Index&m=index';
		GROUP = 'http://localhost/v5/plugin/hd';
		TPL = 'http://localhost/v5/plugin/hd/Plugin/Link/Tpl';
		CONTROLTPL = 'http://localhost/v5/plugin/hd/Plugin/Link/Tpl/Index';
		STATIC = 'http://localhost/v5/plugin/Static';
		PUBLIC = 'http://localhost/v5/plugin/hd/Plugin/Link/Tpl/Public';
		HISTORY = 'http://localhost/v5/plugin/index.php';
		HTTPREFERER = 'http://localhost/v5/plugin/index.php';
</script>
    <script type="text/javascript" src="http://localhost/v5/plugin/hd/Plugin/Link/Tpl/Index/js/link.js"></script>
</head>
<body>
<div id="warpper">

    <div id="g-apply" class="g-apply">
        <div class="m-apply-hd"><h3 class="lks-ico tit">友情链接说明</h3></div>
        <div class="box clearfix">
            <div class="fl m-apply-tip">
                <strong style="color:#2C516D;font-size:14px;">友情链接说明</strong><br/>
                <?php echo $hdcms['comment'];?>
                <br>
                <strong>友链联系方式：</strong><br>
                E-mail: <a href="mailto:<?php echo $hdcms['email'];?>"><?php echo $hdcms['email'];?></a><br/>
                QQ: <a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $hdcms['qq'];?>&site=qq&menu=yes" target="_blank">
                    <img border="0" title="点击这里给我发消息" alt="点击这里给我发消息" src="http://wpa.qq.com/pa?p=2:1455067020:44">
                </a>
            </div>
            <div class="fr m-apply-form" style="height: 250px;">
                <strong style="color:#2C516D;font-size:14px;">图片链接代码</strong><br/>
                <textarea class="w350 h60" style="padding:5px;font-size:12px;" readonly=""><a href="<?php echo $hdcms['url'];?>" target="_blank"><img title="<?php echo $hdcms['webname'];?>" alt="<?php echo $hdcms['webname'];?>" src="http://localhost/v5/plugin/<?php echo $hdcms['logo'];?>" border="0"/></a></textarea>
                <div style="margin-top: 10px;margin-bottom: 15px;">
                示例：<a href="<?php echo $hdcms['url'];?>" target="_blank" style="margin-top: 10px;"><img title="<?php echo $hdcms['webname'];?>" align="middle" class="h30" alt="<?php echo $hdcms['webname'];?>" src="http://localhost/v5/plugin/<?php echo $hdcms['logo'];?>" border="0"/></a>
                </div>
                <strong style="color:#2C516D;font-size:14px;">文字链接代码</strong><br/>
                <textarea id="ImgCode" class="w350 h60" style="padding:5px;font-size:12px;" readonly=""><a href="<?php echo $hdcms['url'];?>" target="_blank"><?php echo $hdcms['webname'];?></a></textarea>
                <br/>
                示例：<a href="<?php echo $hdcms['url'];?>" target="_blank"><?php echo $hdcms['webname'];?></a>
            </div>
        </div>
    </div>
    <!--提交申请-->
    <div id="g-apply" class="g-apply">
        <div class="m-apply-hd"><h3 class="lks-ico tit">提交申请</h3></div>
        <form action="<?php echo U('add',array('g'=>'Plugin'));?>" method="post" enctype="multipart/form-data">
            <table class="table1 hd-form">
                <tr>
                    <th class="w100">链接分类 <span class="star">*</span></th>
                    <td>
                        <select name="tid">
                            <?php $hd["list"]["t"]["total"]=0;if(isset($type) && !empty($type)):$_id_t=0;$_index_t=0;$lastt=min(1000,count($type));
$hd["list"]["t"]["first"]=true;
$hd["list"]["t"]["last"]=false;
$_total_t=ceil($lastt/1);$hd["list"]["t"]["total"]=$_total_t;
$_data_t = array_slice($type,0,$lastt);
if(count($_data_t)==0):echo "";
else:
foreach($_data_t as $key=>$t):
if(($_id_t)%1==0):$_id_t++;else:$_id_t++;continue;endif;
$hd["list"]["t"]["index"]=++$_index_t;
if($_index_t>=$_total_t):$hd["list"]["t"]["last"]=true;endif;?>

                                <option value="<?php echo $t['tid'];?>"><?php echo $t['type_name'];?></option>
                            <?php $hd["list"]["t"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th class="w100">网站名称 <span class="star">*</span></th>
                    <td>
                        <input type="text" name='webname' class="w300"/>
                    </td>
                </tr>
                <tr>
                    <th>网址 <span class="star">*</span></th>
                    <td>
                        <input type="text" name='url' class="w300"/>
                    </td>
                </tr>
                <tr>
                    <th>logo</th>
                    <td>
                        <input type="file" name="logo"/>
                    </td>
                </tr>
                <tr>
                    <th>电子邮箱 <span class="star">*</span></th>
                    <td>
                        <input type="text" name='email' class="w300"/>
                    </td>
                </tr>
                <tr>
                    <th>联系QQ</th>
                    <td>
                        <input type="text" name='qq' class="w300"/>
                    </td>
                </tr>
                <tr>
                    <th>网站介绍</th>
                    <td>
                        <textarea name="comment" class="w400 h100"></textarea>
                    </td>
                </tr>

                <?php if($conf['code'] == 1){?>
                    <tr>
                        <th>验证码</th>
                        <td>
                            <input type="text" name="code"/>
                            <img style="cursor:pointer" src="<?php echo U(code,array('g'=>'Plugin'));?>" alt="验证码"
                                 onclick="update_code()" id="code"/> <a href="javascript:update_code();">看不清，换一张</a>
                            <span id="hd_code"></span>
                        </td>
                    </tr>
                <?php }?>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="提交申请" class="hd-success"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="h50"></div>
</div>
</body>
</html>