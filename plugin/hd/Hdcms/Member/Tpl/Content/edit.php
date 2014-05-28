<!DOCTYPE html>
<html>
	<head>
		<title>添加文章</title>
		<link rel="shortcut icon" href="favicon.ico">
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<hdjs/>
		<bootstrap/>
		<link rel="stylesheet" type="text/css" href="__CONTROL_TPL__/css/content.css?ver=1.0"/>
		<js file="__GROUP__/Hdcms/Admin/Tpl/Content/js/addEdit.js"/>
		<css file="__GROUP__/Hdcms/Admin/Tpl/Content/css/css.css"/>
		<js file="__CONTROL_TPL__/js/js.js"/>
		<link rel="stylesheet" type="text/css" href="__ROOT__/hd/static/css/common.css"/>
	</head>
	<body>
		<load file="__TPL__/Public/block/top_menu.php"/>
		<form method="post" onsubmit="return false;">
			<input type="hidden" name="mid" value="{$hd.request.mid}"/>
    		<input type="hidden" name="aid" value="{$hd.request.aid}"/>
			<div class="main center-block">
				
				<div class="form">
					
					<div class="title-header">添加文章</div>
					<table class="table1">
						<?php foreach($form['base'] as $field):
						?>
						<tr>
							<th class="w80"> {$field['title']} <td> {$field['form']} </td>
						</tr>
						<?php endforeach; ?>
					</table>
					<div class="position-bottom" style="position: relative;">
				<input type="submit" class="hd-success" value="确定"/>
				<input type="button" class="hd-cancel" onclick="hd_close_window()" value="关闭"/>
			</div>
				</div>
				<div class="help">
					<table class="table1">
						<?php foreach($form['nobase'] as $field):
						?>
						<tr>
							<th>{$field['title']}</th>
						</tr>
						<tr>
							<td> {$field['form']} </td>
						</tr>
						<?php endforeach; ?>
					</table>
					<h1 style="margin-top:20px;">提示</h1>
					<ul>
						<li>
							在确认提交代码前，请检查标题和内容是否已经填写完整
						</li>
						<li>
							附件需要被打包成ZIP或RAR压缩文件后才能上传
						</li>
					</ul>
				</div>

			</div>

		</form>
	</body>
</html>