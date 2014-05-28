<!--站内图片-->
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
