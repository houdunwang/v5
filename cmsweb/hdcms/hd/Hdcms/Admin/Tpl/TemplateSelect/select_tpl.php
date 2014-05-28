<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>选择模板</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/select_tpl.js"/>
    <css file="__CONTROL_TPL__/css/select_tpl.css"/>
    <script type="text/javascript" charset="utf-8">
    	var fieldName ="{$hd.get.name}" ;
    </script>
</head>
<body>
<div id="select_tpl" style="overflow-y: auto;height:315px;">
    
</div>
<script type="text/javascript" charset="utf-8">
	$(function(){
		getFileList('{|U:'getFileList'}');
	});
</script>
</body>
</html>