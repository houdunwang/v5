<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>文件管理</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/js.js"/>
    <css file="__CONTROL_TPL__/css/css.css"/>
    <script>
        {$get}
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
                {$upload}
            </div>
            <div id="site" class="pic_list">
                <div class="site_pic">
                    <ul>
                        <list from="$site_data" name="f">
                            <li class="upload_thumb">
                                <img src="<if value='$f.image eq 1'>__ROOT__/{$f.path}<else>__HDPHP_EXTEND__/Org/Uploadify/default.png</if>" path="{$f.path}"/>
                                <input style="padding:3px 0px;width:84px" type="text" name="hdcms[][alt]"
                                       value="{$f.name}" onblur="if(this.value=='')this.value='{$f.name}'"
                                       onfocus="this.value=''">
                                <input type="hidden" name="table_id" value="{$f.id}"/>
                            </li>
                        </list>
                    </ul>
                </div>
                <div class="page1">
                    {$site_page}
                </div>
            </div>
            <div id="untreated" class="pic_list">
                <div class="site_pic">
                    <ul>
                        <list from="$untreated_data" name="f">
                            <li class="upload_thumb">
                                <img src="<if value='$f.image eq 1'>__ROOT__/{$f.path}<else>__HDPHP_EXTEND__/Org/Uploadify/default.png</if>" path="{$f.path}"/>
                                <input style="padding:3px 0px;width:84px" type="text" name="hdcms[][alt]"
                                       value="{$f.name}" onblur="if(this.value=='')this.value='{$f.name}'"
                                       onfocus="this.value=''">
                                <input type="hidden" name="table_id" value="{$f.id}"/>
                            </li>
                        </list>
                    </ul>
                </div>
                <div class="page1">
                    {$untreated_page}
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