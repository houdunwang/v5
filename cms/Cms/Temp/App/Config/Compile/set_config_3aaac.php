<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <script type='text/javascript' src='http://localhost/v5/cms/hdphp/hdphp/../hdjs/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/cms/hdphp/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/cms/hdphp/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/cms/hdphp/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/cms/hdphp/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/cms';
		WEB = 'http://localhost/v5/cms/index.php';
		URL = 'http://localhost/v5/cms/index.php/Config/Config/set_config';
		HDPHP = 'http://localhost/v5/cms/hdphp/hdphp';
		HDPHPDATA = 'http://localhost/v5/cms/hdphp/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/cms/hdphp/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/cms/hdphp/hdphp/Extend';
		APP = 'http://localhost/v5/cms/index.php/Config';
		CONTROL = 'http://localhost/v5/cms/index.php/Config/Config';
		METH = 'http://localhost/v5/cms/index.php/Config/Config/set_config';
		GROUP = 'http://localhost/v5/cms/Cms';
		TPL = 'http://localhost/v5/cms/Cms/App/Config/Tpl';
		CONTROLTPL = 'http://localhost/v5/cms/Cms/App/Config/Tpl/Config';
		STATIC = 'http://localhost/v5/cms/Static';
		PUBLIC = 'http://localhost/v5/cms/Cms/App/Config/Tpl/Public';
		HISTORY = 'http://localhost/v5/cms/index.php/Admin/Index/index';
		HTTPREFERER = 'http://localhost/v5/cms/index.php/Admin/Index/index';
</script>
    </head>
    <body>
    	<div class='wrap'>
		<div class='title-header'>
			网站配置
		</div>
		<form  class='hd-form' method='post'>
			<table class='table1'>
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

				<tr>
					<th class='w100'>
					<?php echo $c['title'];?>
					</th>
					<td class='w200'>
						<?php echo $c['html'];?>
					</td>
					<td>
						<?php echo $c['message'];?>
					</td>
					<td>
						{ $hd.config.<?php echo $c['name'];?> }
					</td>
				</tr>
			<?php $hd["list"]["c"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
			</table>
		
		<div class='position-bottom'>
			<input type="submit" value='确定' class='hd-success'>
		</div>
		</form>	
    	</div>
    </body>
</html>