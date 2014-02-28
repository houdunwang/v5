<load file="__PUBLIC__/public.html"/>
<div class="hd_setup">
    <strong>欢迎使用后盾HD框架，通过HD框架手册或登录<a href="http://bbs.houdunwang.com/">后盾论坛</a>学习使用HD框架安装配置</strong>
    <h2>
        <a href="{|U:'shownode'}">查看所有节点</a>
        <br/>
        <a href="__CONTROL__" class="home">返回安装首页</a>
        <a href="javascript:void(0)"  class="home" onclick="window.close();return false;">关闭</a>
        <a href="{|U:'rbac/lock'}" class="home">锁定SETUP应用</a>
    </h2>
</div>
<form method="post" name="form1" id="form1" action="{|U:addnode}">
    <input type="hidden" name="pid" value="<empty value='{$hd.get.nid}'>0<noempty/>{$hd.get.nid}</empty>"/>
    <div class="setup">
        <dl>
            <dt>添加节点</dt>
            <dd>
                <table>
                    <tr><td width="200">节点名称:</td>
                        <td>
                            <input type="text" name="name" id="name"/>
                        </td>
                    </tr>
                    <tr><td width="200">节点描述:</td>
                        <td>
                            <input type="text" name="title" id="title"/>
                        </td>
                    </tr>
                    <tr>
                        <td width="200">是否开启节点</td>
                        <td><input type="radio" name="state" id="state" value="1"  style="width:20px;" checked="checked"/> 开启
                            <input type="radio" name="state" id="state" value="0"  style="width:20px;"/> 关闭</td>
                    </tr>
                    <tr><td width="200">排序</td>
                        <td>
                            <input type="text" name="sort" id="sort" value="100"/>
                        </td>
                    </tr>
                    <tr><td width="200">节点等级</td>
                        <td>
                            <select name="level">
                                <list from="$node" name="$k">
                                <option value="{$k.level}">{$k.name}</option>
                                </list>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="200"><input type="submit" value="确认" class="query" name="submit"/></td>
                    </tr>
                </table>
            </dd>
        </dl>
    </div>
</form>
<script type="text/javascript">
     $("#form1").submit(function(){
        var stat = true;
        $("#name").next("span").remove();
        if($("#name").val()==''){
            stat = false;
            $("#name").after("<span>节点名称不能为空</span>");
        }
        $("#title").next("span").remove();
        if($("#title").val()==''){
            stat = false;
            $("#title").after("<span>节点描述不能为空</span>");
        }else if(!/^[\u4e00-\u9fa5\w]+$/.test($("#title").val())){
           stat = false;
            $("#title").after("<span>必须为中文</span>");
        }
        $("#sort").next("span").remove();
        if($("#sort").val()!='' &&!/^\d+$/.test($("#sort").val())){
             stat = false;
            $("#sort").after("<span>必须为数字</span>");
        }
        if(!stat)return false;
    })
</script>
</body>
</html>
