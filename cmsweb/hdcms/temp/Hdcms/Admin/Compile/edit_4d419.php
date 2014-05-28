<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>编辑文章</title>
    <script type='text/javascript' src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/cmsweb/hdcms';
		WEB = 'http://localhost/v5/cmsweb/hdcms/index.php';
		URL = 'http://localhost/v5/cmsweb/hdcms/a=Admin&c=Content&m=edit&cid=13&mid=1&aid=3';
		HDPHP = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp';
		HDPHPDATA = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend';
		APP = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin';
		CONTROL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=Content';
		METH = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=Content&m=edit';
		GROUP = 'http://localhost/v5/cmsweb/hdcms/hd';
		TPL = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl';
		CONTROLTPL = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/Content';
		STATIC = 'http://localhost/v5/cmsweb/hdcms/Static';
		PUBLIC = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/Public';
		HISTORY = 'http://localhost/v5/cmsweb/hdcms/a=Admin&c=Content&m=content&mid=1&cid=13&content_state=1';
		HTTPREFERER = 'http://localhost/v5/cmsweb/hdcms/a=Admin&c=Content&m=content&mid=1&cid=13&content_state=1';
		TEMPLATE = 'http://localhost/v5/cmsweb/hdcms/template/default';
		ROOTURL = 'http://localhost/v5/cmsweb/hdcms';
		WEBURL = 'http://localhost/v5/cmsweb/hdcms/index.php';
		CONTROLURL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=Content';
</script>
    <script type="text/javascript" src="http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/Content/js/addEdit.js"></script>
    <link type="text/css" rel="stylesheet" href="http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/Content/css/css.css"/>
</head>
<body>
<form action="<?php echo U(add);?>" method="post" onsubmit="return false;" id="add" class="hd-form">
    <input type="hidden" name="mid" value="<?php echo $_REQUEST['mid'];?>"/>
    <input type="hidden" name="aid" value="<?php echo $_REQUEST['aid'];?>"/>
    <div class="wrap">
        <!--右侧缩略图区域-->
        <div class="content_right">
            <table class="table1">
            	<?php foreach($form['nobase'] as $field):?>
            	<tr>
            		<th><?php echo $field['title'];?></th>
            	</tr>
                <tr>
                    <td>
                       <?php echo $field['form'];?>
                    </td>
                </tr>
                <?php endforeach;?>
                <tr>
            		<th>已审核</th>
            	</tr>
            	<tr>
                    <td>
                       <label><input type="radio" name="content_state" value="1" <?php if($editData['content_state']==1):?>checked=""<?php endif;?>>是</label>
                       &nbsp;&nbsp;
                       <label><input type="radio" name="content_state" value="0" <?php if($editData['content_state']==0):?>checked=""<?php endif;?>>否</label>
                     </td>
                </tr>
            </table>
        </div>
        <div class="content_left">
            <div class="title-header">添加文章</div>
            <table class="table1">
            	<?php foreach($form['base'] as $field):?>
                <tr>
                    <th class="w80">
                    	<?php echo $field['title'];?>
                    <td>
                       <?php echo $field['form'];?>
                    </td>
                </tr>
                <?php endforeach;?>
            </table>
        </div>
    </div>
    <div class="position-bottom">
        <input type="submit" class="hd-success" value="确定"/>
        <input type="button" class="hd-cancel" onclick="hd_close_window()" value="关闭"/>
    </div>
</form>
<script type="text/javascript">
	$('form').validate(<?php echo $formValidate;?>);
</script>
</body>
</html>