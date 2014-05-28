<load file="__PUBLIC__/public.html"/>
<div class="hd_setup">
    <strong>欢迎使用后盾HD框架，通过HD框架手册或登录<a href="http://bbs.houdunwang.com/">后盾论坛</a>学习使用HD框架安装配置</strong>

    <h2>
        <a href="{|U:'showaddnode',array('level'=>0)}" target="_blank;">添加APP应用节点</a>&nbsp;&nbsp;&nbsp;
        <br/>
        <a href="__CONTROL__" class="home">返回安装首页</a>
        <a href="javascript:void(0)" class="home" onclick="window.close();return false;">关闭</a>
        <a href="{|U:'rbac/lock'}" class="home">锁定SETUP应用</a>
    </h2>
</div>
<div class="setup">
    <div id="hd_rbac">
        <?php
        foreach($node as $v){ 
        ?>
        <h1>{$v['title']}<strong>({$v['name']})</strong>&nbsp;&nbsp;
            <a href="{|U:showaddnode,array('nid'=>$v['nid'],'level'=>$v['level'])}" style="font-size:14px;">
                <img src='__TPL__/state/image/add.png' width='16' height='16'/>&nbsp;添加控制器
            </a>&nbsp;&nbsp;
            <a href="{|U:delnode,array('nid'=>$v['nid'])}" style="font-size:14px;">
                <img src='__TPL__/state/image/remove.png' width='16' height='16'/>&nbsp;删除应用
            </a>
        </h1>
        <?php
        if(isset($v['node']) && is_array($v['node'])){
        foreach($v['node'] as $m){
        ?>
        <table>
            <thead>
            <tr>
                <th>
                    {$m['title']}<strong>({$m['name']})</strong>
                    <a href="{|U:showaddnode,array('nid'=>$m['nid'],'level'=>$m['level'])}">
                        添加
                    </a>&nbsp;&nbsp;
                    <a href="{|U:delnode,array('nid'=>$m['nid'])}">
                        删除
                    </a>
                </th>
            </tr>
            </thead>
            <?php
            if(!empty($m['node'])){
            ?>
            <tbody>
            <tr>
                <td>
                    <ul>
                        <?php
                            foreach($m['node'] as $j){
                            ?>
                        <li>
                            {$j['title']}<strong>({$j['name']})</strong>
                            <a href="{|U:'delnode',array('nid'=>$j['nid'])}">
                                删除
                            </a>

                        </li>
                        <?php
                            }
                            ?>
                    </ul>
                </td>
            </tr>
            </tbody>
            <?php
            }
            ?>
        </table>
        <?php
            }}}
        ?>
    </div>

</div>

</body>
</html>
