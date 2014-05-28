<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>会员列表</title>
    <hdjs/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="javascript:;" class="action">会员列表</a></li>
            <li><a href="{|U:'add'}">添加会员</a></li>
        </ul>
    </div>
    <table class="table2 hd-form">
        <thead>
        <tr>
            <td class="w30">uid</td>
            <td class="w200">昵称</td>
            <td class="w200">帐号</td>
            <td>会员组</td>
            <td class="w150">登录时间</td>
            <td class="w150">注册IP</td>
            <td class="w150">最近登录IP</td>
            <td class="w150">锁定</td>
            <td class="w150">积分</td>
            <td class="w150">操作</td>
        </tr>
        </thead>
        <list from="$data" name="d">
            <tr>
                <td>{$d.uid}</td>
                <td>{$d.nickname}</td>
                <td>{$d.username}</td>
                <td>{$d.rname}</td>
                <td>{$d.logintime}</td>
                <td>{$d.regip}</td>
                <td>{$d.lastip}</td>
                <td>
                    <if value="$d.state==0">
                        <font color="red">√</font>
                        <else/>
                        ×
                    </if>
                </td>
                <td>{$d.credits}</td>
                <td>
                    <a href="{|U:'edit',array('uid'=>$d['uid'])}">修改</a>
                    <span class="line">|</span>
                    <if value="$d.state==1">
                    	<a href="javascript:;" onclick="hd_ajax('{|U:'lock'}',{uid:{$d['uid']},state:0})">
                    	锁定</a>
                    <else>
                    	<a href="javascript:;" onclick="hd_ajax('{|U:'lock'}',{uid:{$d['uid']},state:1})">
                    		<font color="red">解定</font>	</a>
                    </if>
                    <span class="line">|</span>
                    <a href="javascript:hd_confirm('确定删除吗？',function(){hd_ajax('{|U:'del'}',{uid:{$d.uid}})})">删除</a>
                </td>
            </tr>
        </list>
    </table>
    <div class="h60"></div>
</div>
</body>
</html>