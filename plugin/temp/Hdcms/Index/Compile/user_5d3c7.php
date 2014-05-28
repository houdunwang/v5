<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><div class="hd_user_alert">
    <div class="hd_user_icon">
        <div class="ico_img">
            <a href="http://localhost/v5/plugin/index.php?<?php echo $field['domain'];?>"><img src="http://localhost/v5/plugin/<?php echo _default($field['icon'],'data/image/user/100.png');?>" alt="admin"/></a>
        </div>
    </div>
    <div class="hd_user_info">
        <div class="nickname"><?php echo $field['nickname'];?></div>
        <div class="logintime">注册时间：<?php echo date('Y-m-d',$field['regtime']);?></div>
        <div class="lasttime">最后登录：<?php echo date('Y-m-d',$field['logintime']);?></div>
        <div class="role">会员等级：<?php echo $role['rname'];?></div>
        <div class="credits">
            <span>积分：</span>
            <div class="credits-bg">
                <?php if($nextRole){?>
                    <div class="credits-num" style="width:<?php echo $field['credits']/$nextRole['creditslower']*100;?>%">
                        <a href="javascript:" title="当前积分<?php echo $field['credits'];?><?php if($nextRole):?>，升级还需要<?php echo $nextRole['creditslower']-$role['creditslower'];?>积分<?php endif;?>">
                            <?php echo $field['credits'];?><?php if($nextRole):?>/<?php echo $nextRole['creditslower'];?><?php endif;?>
                        </a>
                    </div>
                <?php  }else{ ?>
                    <div class="credits-num" style="width:100%">
                        <a href="javascript:" title="当前积分<?php echo $field['credits'];?>">
                            <?php echo $field['credits'];?>
                        </a>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
    <div class="description">
        <?php if($field['signature']){?>
       <?php echo $field['signature'];?>
            <?php  }else{ ?>
            这家伙有点懒，还没有写个性签名
            <?php }?>
    </div>
    <div class="send_message">
        <?php if(isset($_SESSION['uid']) && $_SESSION['uid']!=$field['uid']):?>
            <a href="javascript:;" onclick="message.show(<?php echo $field['uid'];?>,'<?php echo $field['nickname'];?>')">发消息</a>
        <?php endif;?>
        <a href="http://localhost/v5/plugin/index.php?<?php echo $field['domain'];?>">访问主页</a>
        <?php if(isset($_SESSION['uid']) && $_SESSION['uid']!=$field['uid']):?>
            <a href="javascript:;" onclick="user.follow(this,<?php echo $field['uid'];?>)" class="follow"><?php echo $follow;?></a>
        <?php endif;?>
    </div>
</div>