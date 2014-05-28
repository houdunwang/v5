<div class="hd_user_alert">
    <div class="hd_user_icon">
        <div class="ico_img">
            <a href="__WEB__?{$field.domain}"><img src="__ROOT__/{$field.icon|default:'data/image/user/100.png'}" alt="admin"/></a>
        </div>
    </div>
    <div class="hd_user_info">
        <div class="nickname">{$field.nickname}</div>
        <div class="logintime">注册时间：{$field.regtime|date:"Y-m-d",@@}</div>
        <div class="lasttime">最后登录：{$field.logintime|date:"Y-m-d",@@}</div>
        <div class="role">会员等级：{$role.rname}</div>
        <div class="credits">
            <span>积分：</span>
            <div class="credits-bg">
                <if value="$nextRole">
                    <div class="credits-num" style="width:<?php echo $field['credits']/$nextRole['creditslower']*100;?>%">
                        <a href="javascript:" title="当前积分{$field.credits}<?php if($nextRole):?>，升级还需要<?php echo $nextRole['creditslower']-$role['creditslower'];?>积分<?php endif;?>">
                            {$field.credits}<?php if($nextRole):?>/<?php echo $nextRole['creditslower'];?><?php endif;?>
                        </a>
                    </div>
                <else/>
                    <div class="credits-num" style="width:100%">
                        <a href="javascript:" title="当前积分{$field.credits}">
                            {$field.credits}
                        </a>
                    </div>
                </if>
            </div>
        </div>
    </div>
    <div class="description">
        <if value="$field.signature">
       {$field.signature}
            <else/>
            这家伙有点懒，还没有写个性签名
            </if>
    </div>
    <div class="send_message">
        <?php if(isset($_SESSION['uid']) && $_SESSION['uid']!=$field['uid']):?>
            <a href="javascript:;" onclick="message.show({$field.uid},'{$field.nickname}')">发消息</a>
        <?php endif;?>
        <a href="__WEB__?{$field.domain}">访问主页</a>
        <?php if(isset($_SESSION['uid']) && $_SESSION['uid']!=$field['uid']):?>
            <a href="javascript:;" onclick="user.follow(this,{$field.uid})" class="follow">{$follow}</a>
        <?php endif;?>
    </div>
</div>