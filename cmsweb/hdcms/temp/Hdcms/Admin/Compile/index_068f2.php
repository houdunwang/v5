<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>文件管理</title>
    <script type='text/javascript' src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/cmsweb/hdcms';
		WEB = 'http://localhost/v5/cmsweb/hdcms/index.php';
		URL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=ContentUpload&m=index&id=thumb&type=thumb&num=1&name=thumb';
		HDPHP = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp';
		HDPHPDATA = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend';
		APP = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin';
		CONTROL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=ContentUpload';
		METH = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=ContentUpload&m=index';
		GROUP = 'http://localhost/v5/cmsweb/hdcms/hd';
		TPL = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl';
		CONTROLTPL = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/ContentUpload';
		STATIC = 'http://localhost/v5/cmsweb/hdcms/Static';
		PUBLIC = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/Public';
		HISTORY = 'http://localhost/v5/cmsweb/hdcms/a=Admin&c=Content&m=edit&cid=13&mid=1&aid=3';
		HTTPREFERER = 'http://localhost/v5/cmsweb/hdcms/a=Admin&c=Content&m=edit&cid=13&mid=1&aid=3';
		TEMPLATE = 'http://localhost/v5/cmsweb/hdcms/template/default';
		ROOTURL = 'http://localhost/v5/cmsweb/hdcms';
		WEBURL = 'http://localhost/v5/cmsweb/hdcms/index.php';
		CONTROLURL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=ContentUpload';
</script>
    <script type="text/javascript" src="http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/ContentUpload/js/js.js"></script>
    <link type="text/css" rel="stylesheet" href="http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/ContentUpload/css/css.css"/>
    <script>
        <?php echo $get;?>
    </script>
</head>
<body>
<div class="wrap">
    <div class="tab">
        <ul class="tab_menu">
            <li lab="upload"><a href="#">上传文件</a></li>
            <li lab="site"><a href="#">站内文件</a></li>
            <li lab="untreated"><a href="#">未使用文件</a></li>
        </ul>
        <div class="tab_content">
            <div id="upload" style="padding: 5px;">
                <?php echo $upload;?>
            </div>
            <div id="site" class="pic_list">
                <div class="site_pic">
                    <ul>
                        <?php $hd["list"]["f"]["total"]=0;if(isset($site_data) && !empty($site_data)):$_id_f=0;$_index_f=0;$lastf=min(1000,count($site_data));
$hd["list"]["f"]["first"]=true;
$hd["list"]["f"]["last"]=false;
$_total_f=ceil($lastf/1);$hd["list"]["f"]["total"]=$_total_f;
$_data_f = array_slice($site_data,0,$lastf);
if(count($_data_f)==0):echo "";
else:
foreach($_data_f as $key=>$f):
if(($_id_f)%1==0):$_id_f++;else:$_id_f++;continue;endif;
$hd["list"]["f"]["index"]=++$_index_f;
if($_index_f>=$_total_f):$hd["list"]["f"]["last"]=true;endif;?>

                            <li class="upload_thumb">
                                <img src="<?php if($f['image'] == 1){?>http://localhost/v5/cmsweb/hdcms/<?php echo $f['path'];?><?php  }else{ ?>http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend/Org/Uploadify/default.png<?php }?>" path="<?php echo $f['path'];?>"/>
                                <input style="padding:3px 0px;width:84px" type="text" name="hdcms[][alt]"
                                       value="<?php echo $f['name'];?>" onblur="if(this.value=='')this.value='<?php echo $f['name'];?>'"
                                       onfocus="this.value=''">
                                <input type="hidden" name="table_id" value="<?php echo $f['id'];?>"/>
                            </li>
                        <?php $hd["list"]["f"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
                    </ul>
                </div>
                <div class="page1">
                    <?php echo $site_page;?>
                </div>
            </div>
            <div id="untreated" class="pic_list">
                <div class="site_pic">
                    <ul>
                        <?php $hd["list"]["f"]["total"]=0;if(isset($untreated_data) && !empty($untreated_data)):$_id_f=0;$_index_f=0;$lastf=min(1000,count($untreated_data));
$hd["list"]["f"]["first"]=true;
$hd["list"]["f"]["last"]=false;
$_total_f=ceil($lastf/1);$hd["list"]["f"]["total"]=$_total_f;
$_data_f = array_slice($untreated_data,0,$lastf);
if(count($_data_f)==0):echo "";
else:
foreach($_data_f as $key=>$f):
if(($_id_f)%1==0):$_id_f++;else:$_id_f++;continue;endif;
$hd["list"]["f"]["index"]=++$_index_f;
if($_index_f>=$_total_f):$hd["list"]["f"]["last"]=true;endif;?>

                            <li class="upload_thumb">
                                <img src="<?php if($f['image'] == 1){?>http://localhost/v5/cmsweb/hdcms/<?php echo $f['path'];?><?php  }else{ ?>http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend/Org/Uploadify/default.png<?php }?>" path="<?php echo $f['path'];?>"/>
                                <input style="padding:3px 0px;width:84px" type="text" name="hdcms[][alt]"
                                       value="<?php echo $f['name'];?>" onblur="if(this.value=='')this.value='<?php echo $f['name'];?>'"
                                       onfocus="this.value=''">
                                <input type="hidden" name="table_id" value="<?php echo $f['id'];?>"/>
                            </li>
                        <?php $hd["list"]["f"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
                    </ul>
                </div>
                <div class="page1">
                    <?php echo $untreated_page;?>
                </div>
            </div>
        </div>
    </div>
    
</div>
<div class="position-bottom" style="position: fixed;bottom:0px;">
        <input type="button" class="hd-success" id="pic_selected" value="确定"/>
        <input type="button" class="hd-cancel" value="关闭" onclick="close_window();"/>
    </div>
</body>
</html>