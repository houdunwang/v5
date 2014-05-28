<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html>
<html>
<head>
    <title>好友动态</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type='text/javascript' src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/cmsweb/hdcms';
		WEB = 'http://localhost/v5/cmsweb/hdcms/index.php';
		URL = 'http://localhost/v5/cmsweb/hdcms/a=Member&c=Index&m=a=Member&c=Dynamic&m=index';
		HDPHP = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp';
		HDPHPDATA = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend';
		APP = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Member';
		CONTROL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Member&c=Dynamic';
		METH = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Member&c=Dynamic&m=index';
		GROUP = 'http://localhost/v5/cmsweb/hdcms/hd';
		TPL = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Member/Tpl';
		CONTROLTPL = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Member/Tpl/Dynamic';
		STATIC = 'http://localhost/v5/cmsweb/hdcms/Static';
		PUBLIC = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Member/Tpl/Public';
		HISTORY = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin';
		HTTPREFERER = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin';
		TEMPLATE = 'http://localhost/v5/cmsweb/hdcms/template/default';
		ROOTURL = 'http://localhost/v5/cmsweb/hdcms';
		WEBURL = 'http://localhost/v5/cmsweb/hdcms/index.php';
		CONTROLURL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Member&c=Dynamic';
</script>
    <link href='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend/Org/bootstrap/css/bootstrap.min.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend/Org/bootstrap/js/bootstrap.min.js'></script>
                <!--[if lte IE 6]>
                <link rel="stylesheet" type="text/css" href="http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend/Org/bootstrap/ie6/css/bootstrap-ie6.css">
                <![endif]-->
                <!--[if lt IE 9]>
                <script src="http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend/Org/bootstrap/js/html5shiv.min.js"></script>
                <script src="http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend/Org/bootstrap/js/respond.min.js"></script>
                <![endif]-->
    <link rel="stylesheet" type="text/css" href="http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Member/Tpl/Dynamic/css/dynamic.css?ver=1.0"/>
    <script type='text/javascript'>
                    	var ROOT='<?php echo ROOT_URL;?>';var WEB='<?php echo WEB_URL;?>';var CONTROL='<?php echo CONTROL_URL;?>';
                	</script><script type='text/javascript' src='http://localhost/v5/cmsweb/hdcms/hd/Common/static/js/hdcms.js'></script>

                <link rel='stylesheet' type='text/css' href='http://localhost/v5/cmsweb/hdcms/hd/Common/static/css/hdcms.css?ver=1.0'/>

</head>
<body>
<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><header class="header center-block">
    <h1>
        <a href="http://localhost/v5/cmsweb/hdcms">后盾网  人人做后盾</a>
    </h1>
</header>
<nav class="top-menu">
    <div class="nav center-block">
        <a href="http://localhost/v5/cmsweb/hdcms">首页</a>
        <a href="http://localhost/v5/cmsweb/hdcms/index.php?a=Member&c=Content&m=index&mid=1">我的文章</a>
        <a href="http://localhost/v5/cmsweb/hdcms/index.php?<?php echo $_SESSION['domain'];?>" target="_blank">个人空间</a>
        <a href="http://localhost/v5/cmsweb/hdcms/index.php?a=Member&c=Login&m=quit" class="pull-right">退出</a>
    </div>
</nav>
<article class="center-block main">
    <!--左侧导航start-->
    <?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><section class="menu">
    <div class="center-block user">
        <a href="http://localhost/v5/cmsweb/hdcms/index.php?<?php echo $_SESSION['domain'];?>" target="_blank">
            <img src="<?php echo $_SESSION['icon150'];?>" onmouseover="user.show(this,<?php echo $_SESSION['uid'];?>)" style="width:150px;150px;"/>
        </a>
        <p class="nickname">
            <span class="glyphicon glyphicon-user"></span> <b><?php echo $_SESSION['nickname'];?></b></p>
        <p class="edit-nickname" data-toggle="modal" data-target="#myModal">
            <span class="glyphicon glyphicon-cog"></span> 修改昵称
        </p>
        <p>
            金&nbsp;&nbsp;&nbsp; 币：<?php echo $_SESSION['credits'];?> <br/>
        </p>
        <p>
            会员组：<?php echo $_SESSION['rname'];?> <br/>
        </p>
        <!--修改昵称 start--->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog"  >
                <div class="modal-content" style="height:200px;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">修改昵称</h4>
                    </div>
                    <div class="modal-body" style="margin-left: 100px;margin-top:20px;">
                        <form method="post" class="hd-form" id="edit_nickname" onsubmit="return false;">
                            <input type="text" name="nickname" value="<?php echo $_SESSION['nickname'];?>" class="h40 w300"/>
                            <button type="submit" class="btn btn-primary">保存</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <script>
            //修改昵称
            $("#edit_nickname").submit(function(){
                var nickname = $.trim($("input[name=nickname]").val());
                if(!nickname){
                    alert('昵称不能为空');
                    return false;
                }
                $('#myModal').modal('hide');
                $.post("<?php echo U('Profile/editNickname');?>",$(this).serialize(),function(data){
                    if(data.state==1){
                        $('p.nickname b').html(nickname);
                        $('input[name=nickname]').val(nickname);
                    }
                },'json')
            })
        </script>
        <!--修改昵称 end--->
    </div>
    <nav>
        <a href="http://localhost/v5/cmsweb/hdcms/index.php?a=Member&c=Dynamic&m=index">
            <span class="glyphicon glyphicon-share"></span>
            会员动态
        </a>
        <a href="http://localhost/v5/cmsweb/hdcms/index.php?a=Member&c=Profile&m=edit">
            <span class="glyphicon glyphicon-fire"></span>
            修改资料
        </a>
        <?php
            $model = cache('model');
            foreach($model as $m):
        ?>
        <a href="http://localhost/v5/cmsweb/hdcms/index.php?a=Member&c=Content&m=index&mid=<?php echo $m['mid'];?>">
            <span class="glyphicon glyphicon-book"></span>
            <?php echo $m['model_name'];?>
        </a>
        <?php endforeach;?>
        <a href="http://localhost/v5/cmsweb/hdcms/index.php?a=Member&c=SystemMessage&m=index">
            <span class="glyphicon glyphicon-comment"></span>
            系统信息
            <span class="badge"><?php echo $systemmessage_count;?></span>
        </a>
        <a href="http://localhost/v5/cmsweb/hdcms/index.php?a=Member&c=Message&m=index">
            <span class="glyphicon glyphicon-comment"></span>
            我的消息
            <span class="badge"><?php echo $message_count;?></span>
        </a>
        <a href="http://localhost/v5/cmsweb/hdcms/index.php?a=Member&c=Favorite&m=index">
            <span class="glyphicon glyphicon-folder-open"></span>
            我的收藏
        </a>
        <a href="http://localhost/v5/cmsweb/hdcms/index.php?a=Member&c=Follow&m=fans_list">
            <span class="glyphicon glyphicon-send"></span>
            我的粉丝
        </a><a href="http://localhost/v5/cmsweb/hdcms/index.php?a=Member&c=Follow&m=follow_list">
            <span class="glyphicon glyphicon-tower"></span>
            我的关注
        </a>
    </nav>
</section>
    <!--左侧导航end-->
    <section class="article">
        <header>
            <h2>
                会员动态
            </h2>
            <h2 class="disab">
                <a href="<?php echo U('friend');?>">好友动态</a>
            </h2>
        </header>
        <ul>
            <?php $hd["list"]["d"]["total"]=0;if(isset($data) && !empty($data)):$_id_d=0;$_index_d=0;$lastd=min(1000,count($data));
$hd["list"]["d"]["first"]=true;
$hd["list"]["d"]["last"]=false;
$_total_d=ceil($lastd/1);$hd["list"]["d"]["total"]=$_total_d;
$_data_d = array_slice($data,0,$lastd);
if(count($_data_d)==0):echo "";
else:
foreach($_data_d as $key=>$d):
if(($_id_d)%1==0):$_id_d++;else:$_id_d++;continue;endif;
$hd["list"]["d"]["index"]=++$_index_d;
if($_index_d>=$_total_d):$hd["list"]["d"]["last"]=true;endif;?>

                <li>
                    <div class="article">
                    	<a href="http://localhost/v5/cmsweb/hdcms/index.php?<?php echo $d['domain'];?>">
                      		<img src="<?php echo _default($d['icon'],'http://localhost/v5/cmsweb/hdcms/data/image/user/50.png');?>" onmouseover="user.show(this,<?php echo $d['uid'];?>)"/>
                      	</a>
                      	<a href="http://localhost/v5/cmsweb/hdcms/index.php?<?php echo $d['domain'];?>">
                      		<?php echo $d['username'];?>
                      	</a>
                      <?php echo $d['content'];?>
                    </div>
                    <div class="right-action">
                        <span class="time"> <?php echo date_before($d['addtime']);?></span>
                    </div>
                </li>
            <?php $hd["list"]["d"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
        </ul>
    </section>
    <div class="page1 h30">
        <?php echo $page;?>
    </div>
</article>
<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><footer class="container">
    <nav>
        <a href="http://www.houdunwang.com">PHP培训</a>
        <a href="http://www.houdunwang.com">HDPHP框架</a>
        <a href="http://bbs.houdunwang.com">论坛</a>
    </nav>
    <?php echo C("COPYRIGHT");?><a href="#"><?php echo C("ICP");?></a>
</footer>
</body>
</html>