<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>网站配置</title>
    <hdjs/>
    <css file="__CONTROL_TPL__/css/css.css"/>
</head>
<body>
<form action="{|U:edit}" method="post" class="hd-form" onsubmit="return hd_submit(this)">
    <div class="wrap">
        <div class="title-header">温馨提示</div>
        <div class="help">
            1 模板中使用配置项方法为{ $hd.config.变量名}
            <br>
            2 请仔细修改配置项，不当设置将影响网站的性能与安全 <br>
            3 在不了解配置项意义时，请不要随意修改
        </div>
        <div class="tab">
            <ul class="tab_menu">
                <li lab="web"><a href="#">站点配置</a></li>
                <li><li lab="rewrite"><a href="#">伪静态</a></li></li>
                <li lab="upload"><a href="#">上传设置</a></li>
                <li lab="member"><a href="#">会员设置</a></li>
                <li lab="content"><a href="#">内容相关</a></li>
                <li lab="water"><a href="#">水印设置</a></li>
                <li lab="safe"><a href="#">安全配置</a></li>
                <li lab="optimize"><a href="#">性能优化</a></li>
                <li lab="grand"><a href="#">高级配置</a></li>
            </ul>
            <div class="tab_content">
                <div id="web">
                    <table class="table1">
                        <list from="$config.web" name="c">
                            {$c.html}
                        </list>
                    </table>
                </div>
                <div id="rewrite">
                    <table class="table1">
                        <list from="$config.rewrite" name="c">
                            {$c.html}
                        </list>
                    </table>
                </div>
                <div id="upload">
                    <table class="table1">
                        <list from="$config.upload" name="c">
                            {$c.html}
                        </list>
                    </table>
                </div>
                <div id="member">
                    <table class="table1">
                        <list from="$config.member" name="c">
                            {$c.html}
                        </list>
                    </table>
                </div>
                <div id="content">
                    <table class="table1">
                        <list from="$config.content" name="c">
                            {$c.html}
                        </list>
                    </table>
                </div>
                <div id="water">
                    <table class="table1">
                        <list from="$config.water" name="c">
                            {$c.html}
                        </list>
                    </table>
                </div>
                <div id="safe">
                    <table class="table1">
                        <list from="$config.safe" name="c">
                            {$c.html}
                        </list>
                    </table>
                </div>
                <div id="optimize">
                    <table class="table1">
                        <list from="$config.optimize" name="c">
                            {$c.html}
                        </list>
                    </table>
                </div>
                <div id="grand">
                    <table class="table1">
                        <list from="$config.grand" name="c">
                            {$c.html}
                        </list>
                    </table>
                </div>


            </div>
        </div>
    </div>
    <div class="position-bottom">
        <input type="submit" class="hd-success" value="确定"/>
    </div>
</form>
</body>
</html>