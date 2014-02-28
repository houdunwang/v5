<?php if(!defined("HDPHP_PATH"))exit;C("DEBUG_SHOW",false);?><html>
<head>
	<title>添加文章</title>
</head>
<body>
<form action='http://localhost/v5/db.php/News/add' method="post">
		<table>
			<tr>
					<td>标题</td>
					<td>
						<input type="text" name="title"/>
					</td>
			</tr>
			<tr>
					<td>正文</td>
					<td>
						<script charset="utf-8" src="http://localhost/v5/hdphp/hdphp/Extend/Org/Editor/Keditor/kindeditor-all-min.js"></script>
            <script charset="utf-8" src="http://localhost/v5/hdphp/hdphp/Extend/Org/Editor/Keditor/lang/zh_CN.js"></script>
        <textarea id="hd_content" name="content"></textarea>
    <script>
        var options_content = {
        filterMode : false
                ,id : "editor_id"
        ,width : "100%"
        ,height:"300px"
                ,formatUploadUrl:false
        ,allowFileManager:false
        ,allowImageUpload:true
        ,uploadJson : "http://localhost/v5/db.php/News&m=keditor_upload&editor_type=2&Image=1&uploadsize=2000000&maximagewidth=false&maximageheight=false&hdsid=8ucjmo4b2f8d8sjv88bhkhpcr7"//处理上传脚本
        };var hd_content;
        KindEditor.ready(function(K) {
                    hd_content = KindEditor.create("#hd_content",options_content);
        });
        </script>
        
					</td>
			</tr>
			<tr>
					<td colspan="2">
						<input type="submit" value="添加文章"/>
					</td>
			</tr>
		</table>
</form>
</body>
</html>