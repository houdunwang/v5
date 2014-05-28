<!DOCTYPE html>
<html>
<head>
    <title>好友动态</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <hdjs/>
    <bootstrap/>
    <link rel="stylesheet" type="text/css" href="__CONTROL_TPL__/css/dynamic.css?ver=1.0"/>
    <hdcms/>
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
                会员动态
            </h2>
            <h2 class="disab">
                <a href="{|U:'friend'}">好友动态</a>
            </h2>
        </header>
        <ul>
            <list from="$data" name="d">
                <li>
                    <div class="article">
                    	<a href="__WEB__?{$d.domain}">
                      		<img src="{$d.icon|default:'__ROOT__/data/image/user/50.png'}" onmouseover="user.show(this,{$d.uid})"/>
                      	</a>
                      	<a href="__WEB__?{$d.domain}">
                      		{$d.username}
                      	</a>
                      {$d.content}
                    </div>
                    <div class="right-action">
                        <span class="time"> {$d.addtime|date_before}</span>
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