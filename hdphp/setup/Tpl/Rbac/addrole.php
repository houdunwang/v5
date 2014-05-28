<load file="__PUBLIC__/public.html"/>
<div class="hd_setup">
    <strong>欢迎使用后盾HD框架，通过HD框架手册或登录<a href="http://bbs.houdunwang.com/">后盾论坛</a>学习使用HD框架安装配置</strong>
    <h2>
        <a href="__CONTROL__/showrole" target="_self">查看用户组(角色)</a>&nbsp;&nbsp;&nbsp;
        <br/>
        <a href="__CONTROL__" class="home">返回安装首页</a>
        <a href="javascript:void(0)"  class="home" onclick="window.close();return false;">关闭</a>
        <a href="__APP__/rbac/lock" class="home">锁定SETUP应用</a>
    </h2>
</div>
<form method="post" name="form1" id="form1" action="{|U:addentrance}">
    <input type="hidden" name="pid" value="<empty value='{$hd.get.pid}'>0<noempty/>{$hd.get.pid}</empty>"/>
    <div class="setup">
        <dl>
            <dt>添加用户角色（用户组）</dt>
            <dd>
                <table>
                    <tr><td width="200">角色(组)名称:</td>
                        <td>
                            <input type="text" name="rname" id="rname"/><span>必须为英文字母表示</span>
                        </td>
                    </tr>
                    <tr><td width="200">角色描述:</td>
                        <td>
                            <input type="text" name="title" id="title"/><span>中文文字说明</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="200">是否开启角色</td>
                        <td><input type="radio" name="state" id="state" value="1"  style="width:20px;" checked="checked"/> 开启
                            <input type="radio" name="state" id="state" value="0"  style="width:20px;"/> 关闭</td>
                    </tr>
                    <tr><td width="200"><input type="submit" value="确认" class="query" name="submit"/></td></tr>
                </table>
            </dd>
        </dl>
    </div>
</form>
<script type="text/javascript">
     $("#form1").submit(function(){
        var stat = true;
        $("#rname").next("span").remove();
        if($("#rname").val()==''){
            stat = false;
            $("#rname").after("<span>角色不能为空</span>");
        }else if(!/^[a-z]\w+$/.test($("#rname").val())){
            stat = false;
            $("#rname").after("<span>必须为英文</span>");
        }
        $("#title").next("span").remove();
        if($("#title").val()==''){
            stat = false;
            $("#title").after("<span>角色描述不能为空</span>");
        }else if(!/^[\u4e00-\u9fa5]+$/.test($("#title").val())){
            stat = false;
            $("#title").after("<span>必须为中文</span>");
        }
        if(!stat)return false;
    })
</script>
</body>
</html>
