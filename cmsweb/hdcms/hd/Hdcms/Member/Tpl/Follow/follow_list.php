<!DOCTYPE html>
<html>
	<head>
		<title>我的关注</title>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<hdjs/>
		<bootstrap/>
		<link rel="stylesheet" type="text/css" href="__CONTROL_TPL__/css/follow.css?ver=1.0"/>
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
					<h2> 我的关注 </h2>
				</header>
				<ul>
					<list from="$data" name="d">
						<li>
							<div class="icon">
								<img src="{$d['icon']|default:'__ROOT__/data/image/user/100.png'}" onmouseover="user.show(this,{$d.uid})" style="width:100px;"/>
							</div>
							<div class="info">
								<p class="nickname">
									{$d.nickname}
								</p>
								<p>
									关系：
									<a href="javascript:;" onclick="user.follow(this,{$d.uid})" >
										{$d.follow}
									</a>
								</p>
								<p>
									最后登录：{$d.logintime|date:"Y-m-d",@@}
								</p>
								<p>
									<a href="javascript:;" onclick="message.show({$d.uid},'{$d.nickname}')">
										发消息
									</a>
									<a href="__WEB__?{$d.domain}" target="_blank">
										访问主页
									</a>
								</p>
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