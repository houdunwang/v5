<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><?php if($history){?>
        <a href="javascript:;" class="back hd-cancel" onclick="getFileList('<?php echo $history;?>')" style="padding:2px 10px;margin:5px;">返回</a>
<?php }?>
    <table class="table2">
        <thead>
        <tr>
        	<td class="w50">类型</td>
            <td>名称</td>
            <td class="w150">大小</td>
            <td class="w80">修改时间</td>
        </tr>
        </thead>
        <?php $hd["list"]["f"]["total"]=0;if(isset($file) && !empty($file)):$_id_f=0;$_index_f=0;$lastf=min(1000,count($file));
$hd["list"]["f"]["first"]=true;
$hd["list"]["f"]["last"]=false;
$_total_f=ceil($lastf/1);$hd["list"]["f"]["total"]=$_total_f;
$_data_f = array_slice($file,0,$lastf);
if(count($_data_f)==0):echo "";
else:
foreach($_data_f as $key=>$f):
if(($_id_f)%1==0):$_id_f++;else:$_id_f++;continue;endif;
$hd["list"]["f"]["index"]=++$_index_f;
if($_index_f>=$_total_f):$hd["list"]["f"]["last"]=true;endif;?>

            <tr>
            	<td>
            		<?php if($f['type']=='file'){?>
            		<b class='file'>文件</b>
            		<?php  }else{ ?>
            		<b class='dir'>目录</b>
            		<?php }?>
            	</td>
                <td>
                    <div>
	                    <?php if($f['type']=='file'){?>
	            			<a href="javascript:;" class="<?php echo $f['type'];?>"  onclick="getTplFile('<?php echo $f['path'];?>')">
	                            <span class="<?php echo $f['type'];?>"><?php echo $f['name'];?></span>
	                        </a>
	            		<?php  }else{ ?>
	            			<a href="javascript:;" class="<?php echo $f['type'];?>" onclick="getFileList('<?php echo $f['url'];?>');">
	                            <span class="<?php echo $f['type'];?>"><?php echo $f['name'];?></span>
	                        </a>
	            		<?php }?>
                    </div>
                </td>
                <td><?php echo get_size($f['size']);?></td>
                <td><?php echo date('Y-m-d',$f['filemtime']);?></td>
            </tr>
        <?php $hd["list"]["f"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
    </table>