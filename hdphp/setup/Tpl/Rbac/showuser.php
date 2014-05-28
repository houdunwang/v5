<load file="__PUBLIC__/public.html"/>
<div class="hd_setup">
    <strong>欢迎使用后盾HD框架，通过HD框架手册或登录<a href="http://bbs.houdunwang.com/">后盾论坛</a>学习使用HD框架安装配置</strong>

    <h2>
        <a href="{|U:'showadduser'}" target="_self">添加用户</a>&nbsp;&nbsp;&nbsp;
        <a href="{|U:'showrole'}" target="_self">查看用户组(角色)</a>&nbsp;&nbsp;&nbsp;
        <br/>
        <a href="__CONTROL__" class="home">返回安装首页</a>
        <a href="" class="home" onclick="window.close();return false;">关闭</a>
        <a href="{|U:'rbac/lock'}" class="home">锁定SETUP应用</a>
    </h2>
</div>
<div class="setup">
    <dl>
        <dt>用户列表</dt>
        <dd>
            <table width="100%">
                <tr>
                    <td width="100">用户ID</td>
                    <td>用户名称</td>
                    <td width="200">所属组</td>
                    <td width="100">操作</td>
                </tr>
                <list from="$row" name="$v">
                    <tr>
                        <td>{$v.uid}</td>
                        <td>{$v.username}</td>
                        <td>{$v['role'][0]['title']}</td>
                        <td>
                            <a href="{|U:'deluser',array('uid'=>$v['uid'])}">删除</a>&nbsp;&nbsp;&nbsp;
                        </td>
                    </tr>
                </list>

            </table>
        </dd>
    </dl>
</div>
</body>
</html>
