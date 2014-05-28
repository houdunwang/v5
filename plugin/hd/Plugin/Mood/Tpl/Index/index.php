<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <jquery/>
    </head>
    <body>
    	<a href="javascript:mood.set(1);">顶（{$d}）</a>
    	<a href="javascript:mood.set(2);">踩（{$c}）</a>
    	<script type="text/javascript">
    		mood={
			set:function(mood_id){
				param={
					mood_id:mood_id,
					aid:{$hd.get.aid},
					mid:{$hd.get.mid}
				};
				$.post('{|U:"add",array("g"=>"Plugin")}',param,function(Json){
					alert(Json.message);
				},'json');	
			}
		}
    	</script>
    </body>
</html>