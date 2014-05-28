<load file="__PUBLIC__/public.html"/>
<div class="hd_setup">
    <strong>欢迎使用后盾HD框架，通过HD框架手册或登录<a href="http://bbs.houdunwang.com/">后盾论坛</a>学习使用HD框架安装配置</strong>
        <h2><a href="__CONTROL__">返回安装首页</a>
        &nbsp;<a href="__CONTROL__/lock" >锁定SETUP应用</a></h2>
</div>
<form method="post" name="form1" action="__CONTROL__/getallnode">
    <div class="setup">
        <dl>
            <dt>获得应用所有模块节点信息同时写入表</dt>
            <dd>
                <table>
                    <tr><td width="200">应用名称</td>
                        <td>
                            <input type="text" name="appname" id="appname"/>
                            <span>添写应用路径</span>
                        </td>
                    </tr>
                    <tr><td width="200"><input type="submit" value="确认" class="query" name="submit"/></td></tr>
                </table>
            </dd>
        </dl>
    </div>
</form>

</body>
</html>
