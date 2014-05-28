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