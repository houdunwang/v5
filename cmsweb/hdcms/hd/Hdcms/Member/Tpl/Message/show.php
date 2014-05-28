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
</head>
<body>
<load file="__TPL__/Public/block/top_menu.php"/>
<article class="center-block main">
    <!--左侧导航start-->
    <load file="__TPL__/Public/block/left_menu.php"/>
    <!--左侧导航end-->
    <section class="article">
        <form onsubmit="return hd_submit(this,'{|U:'show',array('from_uid'=>$_GET['from_uid'])}')" action="{|U:'reply'}">
            <input type="hidden" name="to_uid" value="{$hd.get.from_uid}"/>
            <table>
                <tr>
                    <td>
                        <textarea name="content" style="width: 100%;height: 80px;"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="回复" class="hd-success"/>
                    </td>
                </tr>
            </table>
        </form>
        <div id="message">
            <list from="$data" name="d">
                <if value="$d.from_uid eq $_SESSION['uid']">
                    <div class="user">
                        <div class="icon">
                            <a href="__WEB__?{$d.from_uid}" target="_blank">
                                <img src="{$d['icon']|default:'__ROOT__/data/image/user/100.png'}" onmouseover="user.show(this,{$hd.session.uid})" style="width:50px;"/>
                            </a>
                        </div>
                        <p>{$d.content}</p>
                    </div>
                <else/>
                    <div class="from">

                        <div class="icon">
                            <a href="__WEB__?{$d.from_uid}" target="_blank">
                                <img src="{$d['icon']|default:'__ROOT__/data/image/user/100.png'}" onmouseover="user.show(this,{$d.from_uid})" style="width:50px;"/>
                            </a>
                        </div>
                        <p>{$d.content}</p>
                    </div>
               </if>
            </list>
        </div>
    </section>

    <div class="page1 h30">
        {$page}
    </div>
</article>
<load file="__TPL__/Public/block/footer.php"/>
</body>
</html>