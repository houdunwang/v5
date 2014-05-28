<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>友情链接-{$hd.config.webname}</title>
    <meta name="keywords" content="{$hd.config.keyworkds}">
    <meta name="description" content="{$hd.config.description}">
    <link href="__CONTROL_TPL__/css/style.css" rel="stylesheet" type="text/css">
    <link href="__CONTROL_TPL__/css/about.css" rel="stylesheet" type="text/css">
    <hdjs/>
    <js file="__CONTROL_TPL__/js/link.js"/>
</head>
<body>
<div id="warpper">

    <div id="g-apply" class="g-apply">
        <div class="m-apply-hd"><h3 class="lks-ico tit">友情链接说明</h3></div>
        <div class="box clearfix">
            <div class="fl m-apply-tip">
                <strong style="color:#2C516D;font-size:14px;">友情链接说明</strong><br/>
                {$hdcms.comment}
                <br>
                <strong>友链联系方式：</strong><br>
                E-mail: <a href="mailto:{$hdcms.email}">{$hdcms.email}</a><br/>
                QQ: <a href="http://wpa.qq.com/msgrd?v=3&uin={$hdcms.qq}&site=qq&menu=yes" target="_blank">
                    <img border="0" title="点击这里给我发消息" alt="点击这里给我发消息" src="http://wpa.qq.com/pa?p=2:1455067020:44">
                </a>
            </div>
            <div class="fr m-apply-form" style="height: 250px;">
                <strong style="color:#2C516D;font-size:14px;">图片链接代码</strong><br/>
                <textarea class="w350 h60" style="padding:5px;font-size:12px;" readonly=""><a href="{$hdcms.url}" target="_blank"><img title="{$hdcms.webname}" alt="{$hdcms.webname}" src="__ROOT__/{$hdcms.logo}" border="0"/></a></textarea>
                <div style="margin-top: 10px;margin-bottom: 15px;">
                示例：<a href="{$hdcms.url}" target="_blank" style="margin-top: 10px;"><img title="{$hdcms.webname}" align="middle" class="h30" alt="{$hdcms.webname}" src="__ROOT__/{$hdcms.logo}" border="0"/></a>
                </div>
                <strong style="color:#2C516D;font-size:14px;">文字链接代码</strong><br/>
                <textarea id="ImgCode" class="w350 h60" style="padding:5px;font-size:12px;" readonly=""><a href="{$hdcms.url}" target="_blank">{$hdcms.webname}</a></textarea>
                <br/>
                示例：<a href="{$hdcms.url}" target="_blank">{$hdcms.webname}</a>
            </div>
        </div>
    </div>
    <!--提交申请-->
    <div id="g-apply" class="g-apply">
        <div class="m-apply-hd"><h3 class="lks-ico tit">提交申请</h3></div>
        <form action="{|U:'add',array('g'=>'Plugin')}" method="post" enctype="multipart/form-data">
            <table class="table1 hd-form">
                <tr>
                    <th class="w100">链接分类 <span class="star">*</span></th>
                    <td>
                        <select name="tid">
                            <list from="$type" name="t">
                                <option value="{$t.tid}">{$t.type_name}</option>
                            </list>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th class="w100">网站名称 <span class="star">*</span></th>
                    <td>
                        <input type="text" name='webname' class="w300"/>
                    </td>
                </tr>
                <tr>
                    <th>网址 <span class="star">*</span></th>
                    <td>
                        <input type="text" name='url' class="w300"/>
                    </td>
                </tr>
                <tr>
                    <th>logo</th>
                    <td>
                        <input type="file" name="logo"/>
                    </td>
                </tr>
                <tr>
                    <th>电子邮箱 <span class="star">*</span></th>
                    <td>
                        <input type="text" name='email' class="w300"/>
                    </td>
                </tr>
                <tr>
                    <th>联系QQ</th>
                    <td>
                        <input type="text" name='qq' class="w300"/>
                    </td>
                </tr>
                <tr>
                    <th>网站介绍</th>
                    <td>
                        <textarea name="comment" class="w400 h100"></textarea>
                    </td>
                </tr>

                <if value="$conf.code eq 1">
                    <tr>
                        <th>验证码</th>
                        <td>
                            <input type="text" name="code"/>
                            <img style="cursor:pointer" src="{|U:code,array('g'=>'Plugin')}" alt="验证码"
                                 onclick="update_code()" id="code"/> <a href="javascript:update_code();">看不清，换一张</a>
                            <span id="hd_code"></span>
                        </td>
                    </tr>
                </if>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="提交申请" class="hd-success"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="h50"></div>
</div>
</body>
</html>