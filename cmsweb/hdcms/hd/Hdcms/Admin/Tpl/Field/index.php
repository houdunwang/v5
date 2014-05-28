<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>模型字段管理</title>
    <hdjs/>
    <css file="__CONTROL_TPL__/css/css.css"/>
    <js file="__CONTROL_TPL__/js/js.js"/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="{|U:'Model/index'}">模型列表</a></li>
            <li><a href="javascript:;" class="action">字段列表</a></li>
            <li><a href="{|U('add',array('mid'=>$_GET['mid']))}">添加字段</a></li>
            <li><a href="javascript:;" onclick="hd_ajax('{|U:updateCache}',{mid:{$hd.get.mid}})">更新缓存</a></li>
        </ul>
    </div>
    <table class="table2 hd-form">
        <thead>
        <tr>
            <td class="w50">排序</td>
            <td class="w50">Fid</td>
            <td class="w200">描述</td>
            <td>字段名</td>
            <td class="w200">表名</td>
            <td class="w100">类型</td>
            <td class="w80">系统</td>
            <td class="w80">必填</td>
            <td class="w80">搜索</td>
            <td class="w80">投稿</td>
            <td class="w120">操作&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        </thead>
        <tbody>
        <list from="$field" name="f">
            <tr>
                <td>
                    <input type="text" name="fieldsort[{$f.fid}]" class="w30" value="{$f.fieldsort}"/>
                </td>
                <td>
                    {$f.fid}
                </td>
                <td>{$f.title}</td>
                <td>{$f.field_name}</td>
                <td>{$f.table_name}</td>
                <td>{$f.field_type}</td>
                <td>
                    <if value="{$f.is_system}">
                    	<font color="red">√</font>
                        <else><font color="blue">×</font>
                    </if>
                </td>
                <td>
                    <if value="{$f.required}">
                    	<font color="red">√</font>
                        <else><font color="blue">×</font>
                    </if>
                </td>
                <td>
                    <if value="{$f.issearch}">
                    	<font color="red">√</font>
                        <else><font color="blue">×</font>
                    </if>
                </td>
                <td>
                    <if value="{$f.isadd}">
                    	<font color="red">√</font>
                        <else><font color="blue">×</font>
                    </if>
                </td>
                <td>
                	 <a href="{|U:'edit',array('mid'=>$f['mid'],'fid'=>$f['fid'])}">修改</a>       
                	 |
                	 <?php if(in_array($f['field_name'],$noallowforbidden)){?>
                	 	<span style='color:#666'>禁用</span>
                	 	<?php }else if($f['field_state']==1){?>
                   <a href="javascript:hd_ajax('{|U:forbidden}',{fid:{$f.fid},field_state:0,mid:{$f.mid}})" >禁用</a>             
                   		<?php }else{?>
                   		<a href="javascript:hd_ajax('{|U:forbidden}',{fid:{$f.fid},field_state:1,mid:{$f.mid}},'__URL__')" style='color:red'>启用</a>			
                   			<?php }?>
                    |
                    <?php if(in_array($f['field_name'],$noallowdelete)):?>
                			<span style='color:#666'>删除</span>
                	<?php else:?>
                		 <a href="javascript:"
                       onclick="return confirm('确定删除【{$f.title}】字段吗？')?hd_ajax('{|U:del}',{mid:{$f['mid']},fid:{$f['fid']}}):false;">删除</a>
                	<?php endif;?>
                   
                </td>
            </tr>
        </list>
        </tbody>
    </table>
    <div class="position-bottom">
        <input type="button" class="hd-success" onclick="update_sort({$hd.get.mid});" value="排序"/>
    </div>
</div>
</body>
</html>