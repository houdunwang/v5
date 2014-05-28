<load file="__PUBLIC__/public.html"/>
<div class="hd_setup">
    <strong>欢迎使用后盾HD框架，通过HD框架手册或登录<a href="http://bbs.houdunwang.com/">后盾论坛</a>学习使用HD框架安装配置</strong>

    <h2>
        <a href="{|U:'addrole'}" target="_self">添加角色</a>&nbsp;&nbsp;&nbsp;
        <br/>
        <a href="__CONTROL__" class="home">返回安装首页</a>
        <a href="javascript:void(0)" class="home" onclick="window.close();return false;">关闭</a>
        <a href="{|U:'rbac/lock'}" class="home">锁定SETUP应用</a>
    </h2>
</div>
<div class="setup">
    <dl>
        <dt>用户角色（用户组）</dt>
        <dd>
            <table width="100%">
                <tr>
                    <td width="100">角色(组)ID</td>
                    <td>角色名称</td>
                    <td width="120">是否开启角色</td>
                    <td width="150">角色描述</td>
                    <td width="180">操作</td>
                </tr>
                <list from="$row" name="$v">
                    <tr>
                        <td>{$v.rid}</td>
                        <td>{$v.rname}</td>
                        <td>
                            <if value="$v.state">开启
                                <else>关闭
                            </if>
                        </td>
                        <td>{$v.title}</td>
                        <td>
                            <a href="{|U('editroleshow',array('rid'=>$v['rid']))}">编辑</a> |
                            <a href="{|U('setaccess',array('rid'=>$v['rid']))}">配置权限</a> |
                            <a href="{|U('delrole',array('rid'=>$v['rid']))}" onclick="return confirm('确认删除')">删除</a>&nbsp;&nbsp;&nbsp;
                        </td>
                    </tr>
                </list>
            </table>
        </dd>
    </dl>
</div>
</body>
</html>
