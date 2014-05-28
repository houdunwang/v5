<!DOCTYPE html>
<html>
<head>
    <title>我的消息</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <hdjs/>
    <bootstrap/>
    <link rel="stylesheet" type="text/css" href="__CONTROL_TPL__/css/message.css?ver=1.0"/>
    <hdcms/>
    <style type="text/css">
    	article.main section.article ul li div.article a{display: inline;}
    </style>
</head>
<body>
<load file="__TPL__/Public/block/top_menu.php"/>
<article class="center-block main">
    <!--左侧导航start-->
    <load file="__TPL__/Public/block/left_menu.php"/>
    <!--左侧导航end-->
    <section class="article">
        <header>
            <h2>
                系统消息
            </h2>
        </header>
        <ul>
            <list from="$data" name="d">
                <li>
                    <div class="article" style="width:650px;">
                      <span style="float:right;font-size;12px;color:#666;">{$d.sendtime|date:'Y-m-d H:i',@@}</span> {$d.message} 
                    </div>
                </li>
            </list>
        </ul>
    </section>
    <div class="page1 h30">
        {$page}
    </div>
</article>
<load file="__TPL__/Public/block/footer.php"/>
</body>
</html>