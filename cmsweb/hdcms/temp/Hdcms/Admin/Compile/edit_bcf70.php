<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>网站配置</title>
    <script type='text/javascript' src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/cmsweb/hdcms';
		WEB = 'http://localhost/v5/cmsweb/hdcms/index.php';
		URL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=Config&m=edit&nid=20&_=0.9674078032840043';
		HDPHP = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp';
		HDPHPDATA = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend';
		APP = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin';
		CONTROL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=Config';
		METH = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=Config&m=edit';
		GROUP = 'http://localhost/v5/cmsweb/hdcms/hd';
		TPL = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl';
		CONTROLTPL = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/Config';
		STATIC = 'http://localhost/v5/cmsweb/hdcms/Static';
		PUBLIC = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/Public';
		HISTORY = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin';
		HTTPREFERER = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin';
		TEMPLATE = 'http://localhost/v5/cmsweb/hdcms/template/default';
		ROOTURL = 'http://localhost/v5/cmsweb/hdcms';
		WEBURL = 'http://localhost/v5/cmsweb/hdcms/index.php';
		CONTROLURL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=Config';
</script>
</head>
<body>
<form action="<?php echo U(edit);?>" method="post" class="hd-form" onsubmit="return hd_submit(this)">
    <div class="wrap">
        <div class="title-header">温馨提示</div>
        <div class="help">
            1 模板中使用配置项方法为{ $hd.config.变量名}
            <br>
            2 请仔细修改配置项，不当设置将影响网站的性能与安全 <br>
            3 在不了解配置项意义时，请不要随意修改
        </div>
        <div class="tab">
            <ul class="tab_menu">
                <li lab="web"><a href="#">站点配置</a></li>
                <li><li lab="rewrite"><a href="#">伪静态</a></li></li>
                <li lab="upload"><a href="#">上传配置</a></li>
                <li lab="member"><a href="#">会员配置</a></li>
                <li lab="content"><a href="#">内容相关</a></li>
                <li lab="water"><a href="#">水印配置</a></li>
                <li lab="safe"><a href="#">安全配置</a></li>
                <li lab="optimize"><a href="#">性能优化</a></li>
                <li lab="email"><a href="#">邮箱配置</a></li>
                <li lab="cookie"><a href="#">COOKIE配置</a></li>
                <li lab="session"><a href="#">SESSION配置</a></li>
            </ul>
            <div class="tab_content">
                <div id="web">
                    <table class="table1">
                    	<tr style="background: #E6E6E6;">
                    		<th  class="w150">标题</th>
                    		<th>配置</th>
                    		<th class="w300">变量</th>
                    		<th class="w300">描述</th>
                    	</tr>
                        <?php $hd["list"]["c"]["total"]=0;if(isset($config) && !empty($config)):$_id_c=0;$_index_c=0;$lastc=min(1000,count($config));
$hd["list"]["c"]["first"]=true;
$hd["list"]["c"]["last"]=false;
$_total_c=ceil($lastc/1);$hd["list"]["c"]["total"]=$_total_c;
$_data_c = array_slice($config,0,$lastc);
if(count($_data_c)==0):echo "";
else:
foreach($_data_c as $key=>$c):
if(($_id_c)%1==0):$_id_c++;else:$_id_c++;continue;endif;
$hd["list"]["c"]["index"]=++$_index_c;
if($_index_c>=$_total_c):$hd["list"]["c"]["last"]=true;endif;?>

                        	<?php if($c['type'] == '站点配置'){?>
                        		<tr>
	                        		<td><?php echo $c['title'];?></td>
	                        		<td><?php echo $c['html'];?></td>
	                        		<td><?php echo $c['name'];?></td>
	                        		<td><?php echo $c['message'];?></td>
                        		</tr>
                            <?php }?>
                        <?php $hd["list"]["c"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
                    </table>
                </div>
                <div id="rewrite">
                    <table class="table1">
                    	<tr style="background: #E6E6E6;">
                    		<th  class="w150">标题</th>
                    		<th>配置</th>
                    		<th class="w300">变量</th>
                    		<th class="w300">描述</th>
                    	</tr>
                        <?php $hd["list"]["c"]["total"]=0;if(isset($config) && !empty($config)):$_id_c=0;$_index_c=0;$lastc=min(1000,count($config));
$hd["list"]["c"]["first"]=true;
$hd["list"]["c"]["last"]=false;
$_total_c=ceil($lastc/1);$hd["list"]["c"]["total"]=$_total_c;
$_data_c = array_slice($config,0,$lastc);
if(count($_data_c)==0):echo "";
else:
foreach($_data_c as $key=>$c):
if(($_id_c)%1==0):$_id_c++;else:$_id_c++;continue;endif;
$hd["list"]["c"]["index"]=++$_index_c;
if($_index_c>=$_total_c):$hd["list"]["c"]["last"]=true;endif;?>

                        	<?php if($c['type'] == '伪静态'){?>
                        		<tr>
	                        		<td><?php echo $c['title'];?></td>
	                        		<td><?php echo $c['html'];?></td>
	                        		<td><?php echo $c['name'];?></td>
	                        		<td><?php echo $c['message'];?></td>
                        		</tr>
                            <?php }?>
                        <?php $hd["list"]["c"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
                    </table>
                </div>
                <div id="upload">
                    <table class="table1">
                    	<tr style="background: #E6E6E6;">
                    		<th  class="w150">标题</th>
                    		<th>配置</th>
                    		<th class="w300">变量</th>
                    		<th class="w300">描述</th>
                    	</tr>
                       <?php $hd["list"]["c"]["total"]=0;if(isset($config) && !empty($config)):$_id_c=0;$_index_c=0;$lastc=min(1000,count($config));
$hd["list"]["c"]["first"]=true;
$hd["list"]["c"]["last"]=false;
$_total_c=ceil($lastc/1);$hd["list"]["c"]["total"]=$_total_c;
$_data_c = array_slice($config,0,$lastc);
if(count($_data_c)==0):echo "";
else:
foreach($_data_c as $key=>$c):
if(($_id_c)%1==0):$_id_c++;else:$_id_c++;continue;endif;
$hd["list"]["c"]["index"]=++$_index_c;
if($_index_c>=$_total_c):$hd["list"]["c"]["last"]=true;endif;?>

                        	<?php if($c['type'] == '上传配置'){?>
                        		<tr>
	                        		<td><?php echo $c['title'];?></td>
	                        		<td><?php echo $c['html'];?></td>
	                        		<td><?php echo $c['name'];?></td>
	                        		<td><?php echo $c['message'];?></td>
                        		</tr>
                            <?php }?>
                        <?php $hd["list"]["c"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
                    </table>
                </div>
                <div id="member">
                    <table class="table1">
                    	<tr style="background: #E6E6E6;">
                    		<th  class="w150">标题</th>
                    		<th>配置</th>
                    		<th class="w300">变量</th>
                    		<th class="w300">描述</th>
                    	</tr>
                    	<?php $hd["list"]["c"]["total"]=0;if(isset($config) && !empty($config)):$_id_c=0;$_index_c=0;$lastc=min(1000,count($config));
$hd["list"]["c"]["first"]=true;
$hd["list"]["c"]["last"]=false;
$_total_c=ceil($lastc/1);$hd["list"]["c"]["total"]=$_total_c;
$_data_c = array_slice($config,0,$lastc);
if(count($_data_c)==0):echo "";
else:
foreach($_data_c as $key=>$c):
if(($_id_c)%1==0):$_id_c++;else:$_id_c++;continue;endif;
$hd["list"]["c"]["index"]=++$_index_c;
if($_index_c>=$_total_c):$hd["list"]["c"]["last"]=true;endif;?>

                        	<?php if($c['type'] == '会员配置'){?>
                        		<tr>
	                        		<td><?php echo $c['title'];?></td>
	                        		<td><?php echo $c['html'];?></td>
	                        		<td><?php echo $c['name'];?></td>
	                        		<td><?php echo $c['message'];?></td>
                        		</tr>
                            <?php }?>
                        <?php $hd["list"]["c"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
                    </table>
                </div>
                <div id="content">
                    <table class="table1">
                    	<tr style="background: #E6E6E6;">
                    		<th  class="w150">标题</th>
                    		<th>配置</th>
                    		<th class="w300">变量</th>
                    		<th class="w300">描述</th>
                    	</tr>
                    	<?php $hd["list"]["c"]["total"]=0;if(isset($config) && !empty($config)):$_id_c=0;$_index_c=0;$lastc=min(1000,count($config));
$hd["list"]["c"]["first"]=true;
$hd["list"]["c"]["last"]=false;
$_total_c=ceil($lastc/1);$hd["list"]["c"]["total"]=$_total_c;
$_data_c = array_slice($config,0,$lastc);
if(count($_data_c)==0):echo "";
else:
foreach($_data_c as $key=>$c):
if(($_id_c)%1==0):$_id_c++;else:$_id_c++;continue;endif;
$hd["list"]["c"]["index"]=++$_index_c;
if($_index_c>=$_total_c):$hd["list"]["c"]["last"]=true;endif;?>

                        	<?php if($c['type'] == '内容相关'){?>
                        		<tr>
	                        		<td><?php echo $c['title'];?></td>
	                        		<td><?php echo $c['html'];?></td>
	                        		<td><?php echo $c['name'];?></td>
	                        		<td><?php echo $c['message'];?></td>
                        		</tr>
                            <?php }?>
                        <?php $hd["list"]["c"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
                    </table>
                </div>
                <div id="water">
                    <table class="table1">
                    	<tr style="background: #E6E6E6;">
                    		<th  class="w150">标题</th>
                    		<th>配置</th>
                    		<th class="w300">变量</th>
                    		<th class="w300">描述</th>
                    	</tr>
                    	<?php $hd["list"]["c"]["total"]=0;if(isset($config) && !empty($config)):$_id_c=0;$_index_c=0;$lastc=min(1000,count($config));
$hd["list"]["c"]["first"]=true;
$hd["list"]["c"]["last"]=false;
$_total_c=ceil($lastc/1);$hd["list"]["c"]["total"]=$_total_c;
$_data_c = array_slice($config,0,$lastc);
if(count($_data_c)==0):echo "";
else:
foreach($_data_c as $key=>$c):
if(($_id_c)%1==0):$_id_c++;else:$_id_c++;continue;endif;
$hd["list"]["c"]["index"]=++$_index_c;
if($_index_c>=$_total_c):$hd["list"]["c"]["last"]=true;endif;?>

                        	<?php if($c['type'] == '水印配置'){?>
                        		<tr>
	                        		<td><?php echo $c['title'];?></td>
	                        		<td><?php echo $c['html'];?></td>
	                        		<td><?php echo $c['name'];?></td>
	                        		<td><?php echo $c['message'];?></td>
                        		</tr>
                            <?php }?>
                        <?php $hd["list"]["c"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
                    </table>
                </div>
                <div id="safe">
                    <table class="table1">
                    	<tr style="background: #E6E6E6;">
                    		<th  class="w150">标题</th>
                    		<th>配置</th>
                    		<th class="w300">变量</th>
                    		<th class="w300">描述</th>
                    	</tr>
                    	<?php $hd["list"]["c"]["total"]=0;if(isset($config) && !empty($config)):$_id_c=0;$_index_c=0;$lastc=min(1000,count($config));
$hd["list"]["c"]["first"]=true;
$hd["list"]["c"]["last"]=false;
$_total_c=ceil($lastc/1);$hd["list"]["c"]["total"]=$_total_c;
$_data_c = array_slice($config,0,$lastc);
if(count($_data_c)==0):echo "";
else:
foreach($_data_c as $key=>$c):
if(($_id_c)%1==0):$_id_c++;else:$_id_c++;continue;endif;
$hd["list"]["c"]["index"]=++$_index_c;
if($_index_c>=$_total_c):$hd["list"]["c"]["last"]=true;endif;?>

                        	<?php if($c['type'] == '安全配置'){?>
                        		<tr>
	                        		<td><?php echo $c['title'];?></td>
	                        		<td><?php echo $c['html'];?></td>
	                        		<td><?php echo $c['name'];?></td>
	                        		<td><?php echo $c['message'];?></td>
                        		</tr>
                            <?php }?>
                        <?php $hd["list"]["c"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
                    </table>
                </div>
                <div id="optimize">
                    <table class="table1">
                    	<tr style="background: #E6E6E6;">
                    		<th  class="w150">标题</th>
                    		<th>配置</th>
                    		<th class="w300">变量</th>
                    		<th class="w300">描述</th>
                    	</tr>
                    	<?php $hd["list"]["c"]["total"]=0;if(isset($config) && !empty($config)):$_id_c=0;$_index_c=0;$lastc=min(1000,count($config));
$hd["list"]["c"]["first"]=true;
$hd["list"]["c"]["last"]=false;
$_total_c=ceil($lastc/1);$hd["list"]["c"]["total"]=$_total_c;
$_data_c = array_slice($config,0,$lastc);
if(count($_data_c)==0):echo "";
else:
foreach($_data_c as $key=>$c):
if(($_id_c)%1==0):$_id_c++;else:$_id_c++;continue;endif;
$hd["list"]["c"]["index"]=++$_index_c;
if($_index_c>=$_total_c):$hd["list"]["c"]["last"]=true;endif;?>

                        	<?php if($c['type'] == '性能优化'){?>
                        		<tr>
	                        		<td><?php echo $c['title'];?></td>
	                        		<td><?php echo $c['html'];?></td>
	                        		<td><?php echo $c['name'];?></td>
	                        		<td><?php echo $c['message'];?></td>
                        		</tr>
                            <?php }?>
                        <?php $hd["list"]["c"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
                    </table>
                </div>
                <div id="email">
                    <table class="table1">
                    	<tr style="background: #E6E6E6;">
                    		<th  class="w150">标题</th>
                    		<th>配置</th>
                    		<th class="w300">变量</th>
                    		<th class="w300">描述</th>
                    	</tr>
                    	<?php $hd["list"]["c"]["total"]=0;if(isset($config) && !empty($config)):$_id_c=0;$_index_c=0;$lastc=min(1000,count($config));
$hd["list"]["c"]["first"]=true;
$hd["list"]["c"]["last"]=false;
$_total_c=ceil($lastc/1);$hd["list"]["c"]["total"]=$_total_c;
$_data_c = array_slice($config,0,$lastc);
if(count($_data_c)==0):echo "";
else:
foreach($_data_c as $key=>$c):
if(($_id_c)%1==0):$_id_c++;else:$_id_c++;continue;endif;
$hd["list"]["c"]["index"]=++$_index_c;
if($_index_c>=$_total_c):$hd["list"]["c"]["last"]=true;endif;?>

                        	<?php if($c['type'] == '邮箱配置'){?>
                        		<tr>
	                        		<td><?php echo $c['title'];?></td>
	                        		<td><?php echo $c['html'];?></td>
	                        		<td><?php echo $c['name'];?></td>
	                        		<td><?php echo $c['message'];?></td>
                        		</tr>
                            <?php }?>
                        <?php $hd["list"]["c"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
                        <tr>
                        	<td colspan="4">
                        		<button class="hd-cancel-small" id="checkEmail" type="button">发邮件测试</button>
                        	</td>
                        </tr>
                    </table>
                </div>
                <div id="cookie">
                    <table class="table1">
                    	<tr style="background: #E6E6E6;">
                    		<th  class="w150">标题</th>
                    		<th>配置</th>
                    		<th class="w300">变量</th>
                    		<th class="w300">描述</th>
                    	</tr>
                    	<?php $hd["list"]["c"]["total"]=0;if(isset($config) && !empty($config)):$_id_c=0;$_index_c=0;$lastc=min(1000,count($config));
$hd["list"]["c"]["first"]=true;
$hd["list"]["c"]["last"]=false;
$_total_c=ceil($lastc/1);$hd["list"]["c"]["total"]=$_total_c;
$_data_c = array_slice($config,0,$lastc);
if(count($_data_c)==0):echo "";
else:
foreach($_data_c as $key=>$c):
if(($_id_c)%1==0):$_id_c++;else:$_id_c++;continue;endif;
$hd["list"]["c"]["index"]=++$_index_c;
if($_index_c>=$_total_c):$hd["list"]["c"]["last"]=true;endif;?>

                        	<?php if($c['type'] == 'COOKIE配置'){?>
                        		<tr>
	                        		<td><?php echo $c['title'];?></td>
	                        		<td><?php echo $c['html'];?></td>
	                        		<td><?php echo $c['name'];?></td>
	                        		<td><?php echo $c['message'];?></td>
                        		</tr>
                            <?php }?>
                        <?php $hd["list"]["c"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
                    </table>
                </div>
                <div id="session">
                    <table class="table1">
                    	<tr style="background: #E6E6E6;">
                    		<th  class="w150">标题</th>
                    		<th>配置</th>
                    		<th class="w300">变量</th>
                    		<th class="w300">描述</th>
                    	</tr>
                    	<?php $hd["list"]["c"]["total"]=0;if(isset($config) && !empty($config)):$_id_c=0;$_index_c=0;$lastc=min(1000,count($config));
$hd["list"]["c"]["first"]=true;
$hd["list"]["c"]["last"]=false;
$_total_c=ceil($lastc/1);$hd["list"]["c"]["total"]=$_total_c;
$_data_c = array_slice($config,0,$lastc);
if(count($_data_c)==0):echo "";
else:
foreach($_data_c as $key=>$c):
if(($_id_c)%1==0):$_id_c++;else:$_id_c++;continue;endif;
$hd["list"]["c"]["index"]=++$_index_c;
if($_index_c>=$_total_c):$hd["list"]["c"]["last"]=true;endif;?>

                        	<?php if($c['type'] == 'SESSION配置'){?>
                        		<tr>
	                        		<td><?php echo $c['title'];?></td>
	                        		<td><?php echo $c['html'];?></td>
	                        		<td><?php echo $c['name'];?></td>
	                        		<td><?php echo $c['message'];?></td>
                        		</tr>
                            <?php }?>
                        <?php $hd["list"]["c"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="position-bottom">
        <input type="submit" class="hd-success" value="确定"/>
    </div>
</form>
<script type="text/javascript" charset="utf-8">
	$("#checkEmail").click(function(){
		$.post("<?php echo U('checkEmail');?>",$('form').serialize(),function(json){
				if(json.state){
					alert(json.message);
				}else{
					alert(json.message);
				}
			},'json');
	})
</script>
</body>
</html>