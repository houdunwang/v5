<load file="__PUBLIC__/public.html"/>
<div class="hd_setup">
    <h2>
        <a href="javascript:void(0)"  class="home" onclick="window.close();return false;">关闭</a>
        <a href="__APP__/rbac/lock" class="home">锁定SETUP应用</a>
    </h2>
</div>
<div style='color:#f00;font-size:14px; font-weight:bold;border:solid 1px #f00;padding:8px;width:600px; margin-left:20px;'>严重：请在网站上线后将setup目录删除！</div>
<form id="form1" method="post" name="form1" action="__CONTROL__&m=setup">
    <input type="hidden" name='path_root' value="{$hd.get.path_root}"/>
    <input type="hidden" name='root' value="{$hd.get.root}"/>
    <div class="setup">
        <dl>
            <dt>添加单入口文件</dt>
            <dd>
                <table>
                    <tr><td width="200">应用组名称[选填]:</td><td>
                            <input type="text" name="appgroup" id="appgroup"/>
                            <span class="msg">如果填写表示将所有应用放入这个文件夹，即所有应用通过一个单入口访问</td></tr>
                    <tr><td width="200">应用名称[选填]:</td><td>
                            <input type="text" name="appname" id="appname"/><br/>
                            <span class="msg">应用的目录名称</span></td></tr>
                    <tr><td width="200">单入口文件名:</td><td>
                            <input type="text" name="filename" id="filename"/></td></tr>
                    <tr><td width="200">是否生成编译文件:</td>
                        <td><input type="radio" name="compile" value ="1" style="width:20px;" checked="checked"/>生成&nbsp;
                            <input type="radio" name="compile" value ="0" style="width:20px;"/>不生成</td></tr>
                    <tr><td width="200"><input type="submit" value="确认" class="query" name="submit"/></td></tr>
                </table>
            </dd>
        </dl>
    </div>
</form>
<script type="text/javascript">
    $("#form1").submit(function(){
        var stat = true;
        $("#filename").next("span").remove();
        if($("#filename").val()==''){
            stat = false;
            $("#filename").after("<span>单入口文件名不能为空</span>");
        }
        if($("#appgroup").val()=='' && $("#appname").val()==''  ){
            stat=false;
            alert("1、应用组或应用名必须设置一个\n2、初学者建议只设置应用名称");
        }
        if(!stat)return false;
    })
</script>
</body>
</html>

