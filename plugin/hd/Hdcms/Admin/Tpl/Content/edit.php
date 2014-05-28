<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>编辑文章</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/addEdit.js"/>
    <css file="__CONTROL_TPL__/css/css.css"/>
</head>
<body>
<form action="{|U:add}" method="post" onsubmit="return false;" id="add" class="hd-form">
    <input type="hidden" name="mid" value="{$hd.request.mid}"/>
    <input type="hidden" name="aid" value="{$hd.request.aid}"/>
    <div class="wrap">
        <!--右侧缩略图区域-->
        <div class="content_right">
            <table class="table1">
            	<?php foreach($form['nobase'] as $field):?>
            	<tr>
            		<th>{$field['title']}</th>
            	</tr>
                <tr>
                    <td>
                       {$field['form']}
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
                    	{$field['title']}
                    <td>
                       {$field['form']}
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
	$('form').validate({$formValidate});
</script>
</body>
</html>