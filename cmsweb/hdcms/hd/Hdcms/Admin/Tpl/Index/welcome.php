<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
		<title>HDCMS快速建站利器</title>
		<hdjs/>
		<css file="__CONTROL_TPL__/css/welcome.css"/>
	</head>
	<body>
		<div class="wrap">
			<div class="title-header">
				温馨提示
			</div>
			<table class="table2">
				<tr>
					<td style="color:red;font-weight: bold;"> HDCMS是国内唯一真正的百分百免费开源产品，您不用担心任何版权问题。 </td>
				</tr>
			</table>
			<div class="title-header">
				安全提示
			</div>
			<table class="table2">
				<tr>
					<td>1. 默认应用组目录hdphp(及子目录)设置为750,文件设置为640</td>
				</tr>
				<tr>
					<td>2. 建议删除安装目录install</td>
				</tr>
			</table>
			<div style="height:10px;overflow: hidden">
				&nbsp;
			</div>
			<div class="title-header">
				HDCMS动态
			</div>
			<table class="table2">
				<tr>
					<td>
					<a href="http://www.hdphp.com" target="_blank">
						>>查看所有动态
					</a></td>
				</tr>
			</table>
			<div class="title-header">
				BUG反馈
			</div>
			<table class="table2">
				<tr>
					<td style="color:red">
					<a href="http://www.hdphp.com/index.php?list_2.html" target="_blank">
						提交反馈
					</a></td>
				</tr>
			</table>
			<div style="height:10px;overflow: hidden">
				&nbsp;
			</div>
			<div class="title-header">
				系统信息
			</div>
			<table class="table2">
				<tr>
					<td class="w80">HDCMS版本</td>
					<td> {$hd.config.HDCMS_NAME} </td>
				</tr>
				<tr>
					<td class="w80">版本号</td>
					<td><font color="red">{$hd.config.HDCMS_VERSION}</font></td>
				</tr>
				<tr>
					<td class="w80">核心框架</td>
					<td>
					<a href="http://www.hdphp.com" target="_blank">
						HDPHP
					</a></td>
				</tr>
				<tr>
					<td>PHP版本</td>
					<td><?php echo PHP_OS; ?></td>
				</tr>
				<tr>
					<td>运行环境</td>
					<td> {$hd.SERVER.SERVER_SOFTWARE} </td>
				</tr>
				<tr>
					<td>允许上传大小</td>
					<td><?php echo ini_get("upload_max_filesize"); ?></td>
				</tr>
				<tr>
					<td>剩余空间</td>
					<td><?php echo get_size(disk_free_space(".")); ?></td>
				</tr>
			</table>
			<div style="height:10px;overflow: hidden">
				&nbsp;
			</div>
			<div class="title-header">
				程序团队
			</div>
			<table class="table2">
				<tr>
					<td class="w80">版权所有</td>
					<td>
					<a href="http://www.houdunwang.com" target="_blank">
						后盾网
					</a> &
					<a href="http://www.hdphp.com" target="_blank">
						HDCMS
					</a></td>
				</tr>
				<tr>
					<td>作者</td>
					<td> 后盾网向军 </td>
				</tr>
				<tr>
					<td>鸣谢</td>
					<td>
					<a href="http://bbs.houdunwang.com" target="_blank">
						后盾网所有盾友
					</a></td>
				</tr>
			</table>
			<div style="height:10px;overflow: hidden">
				&nbsp;
			</div>
		</div>
		<script type="text/javascript" charset="utf-8">
			$.ajax({
				url:'http://www.hdphp.com/index.php?a=Admin&c=Version&m=checkVersion',
				dataType:"jsonp",
				data:{version:'{$hd.config.HDCMS_VERSION}'},
				crossDomain:true
			});
			function JsonpCallBack(json){
				if (json.state == 1) {
							$.modal({
				            width: 420,
				            height: 180,
				            title: "温馨提示",
				            message: json.message,
				            button_cancel: "关闭",
				            type:'success',//类型
        				});
        			}
			}
		</script>
	</body>
</html>