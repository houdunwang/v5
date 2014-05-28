<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<title>操作成功</title>
		<link rel="stylesheet" type="text/css" href="http://localhost/v5/plugin/hd/Common/Template/css.css"/>
	</head>
	<body>
		<div class="wrap">
			<div class="title">
				操作成功
			</div>
			<div class="content">
				<div class="icon"></div>
				<div class="message">
					<div style="margin-top:10px;margin-bottom:15px;">
						<?php echo $msg;?>
					</div>
					<a href="javascript:<?php echo $url;?>" class="hd-cancel">
						返回
					</a>
				</div>
			</div>
		</div>
		<script type="text/javascript">
window.setTimeout("<?php echo $url;?>",<?php echo $time;?>*500);
		</script>
	</body>
</html>