<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <script type='text/javascript' src='http://localhost/v5/plugin/hd/HDPHP/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>

    </head>
    <body>
    	<a href="javascript:mood.set(1);">顶（1）</a>
    	<a href="javascript:mood.set(2);">踩（2）</a>
    	<script type="text/javascript">
    		mood={
			set:function(mood_id){
				param={
					mood_id:mood_id,
					aid:<?php echo $_GET['aid'];?>,
					mid:<?php echo $_GET['mid'];?>
				};
				$.post('<?php echo U(add);?>',param,function(Json){
					alert(Json.message);
				},'json');	
			}
		}
    	</script>
    </body>
</html>