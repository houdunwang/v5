<section class="menu">
    <div class="center-block user">
        <a href="__WEB__?{$hd.session.domain}" target="_blank">
            <img src="{$hd.session.icon150}" onmouseover="user.show(this,{$hd.session.uid})" style="width:150px;150px;"/>
        </a>
        <p class="nickname">
            <span class="glyphicon glyphicon-user"></span> <b>{$hd.session.nickname}</b></p>
        <p class="edit-nickname" data-toggle="modal" data-target="#myModal">
            <span class="glyphicon glyphicon-cog"></span> 修改昵称
        </p>
        <p>
            金&nbsp;&nbsp;&nbsp; 币：{$hd.session.credits} <br/>
        </p>
        <p>
            会员组：{$hd.session.rname} <br/>
        </p>
        <!--修改昵称 start--->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog"  >
                <div class="modal-content" style="height:200px;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">修改昵称</h4>
                    </div>
                    <div class="modal-body" style="margin-left: 100px;margin-top:20px;">
                        <form method="post" class="hd-form" id="edit_nickname" onsubmit="return false;">
                            <input type="text" name="nickname" value="{$hd.session.nickname}" class="h40 w300"/>
                            <button type="submit" class="btn btn-primary">保存</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <script>
            //修改昵称
            $("#edit_nickname").submit(function(){
                var nickname = $.trim($("input[name=nickname]").val());
                if(!nickname){
                    alert('昵称不能为空');
                    return false;
                }
                $('#myModal').modal('hide');
                $.post("{|U:'Home/User/edit_nickname',array('g'=>'Member')}",$(this).serialize(),function(data){
                    if(data.state==1){
                        $('p.nickname b').html(nickname);
                        $('input[name=nickname]').val(nickname);
                    }
                },'json')
            })
        </script>
        <!--修改昵称 end--->
    </div>
    <nav>
        <a href="__WEB__?a=Member&c=Dynamic&m=index">
            <span class="glyphicon glyphicon-share"></span>
            好友动态
        </a>
        <a href="__WEB__?a=Member&c=Profile&m=edit">
            <span class="glyphicon glyphicon-fire"></span>
            修改资料
        </a>
        <?php
            $model = cache('model');
            foreach($model as $m):
        ?>
        <a href="__WEB__?a=Member&c=Content&m=index&mid=<?php echo $m['mid'];?>">
            <span class="glyphicon glyphicon-book"></span>
            <?php echo $m['model_name'];?>
        </a>
        <?php endforeach;?>
        <a href="__WEB__?a=Member&c=Message&m=index">
            <span class="glyphicon glyphicon-comment"></span>
            我的消息
            <span class="badge">{$message_count}</span>
        </a>
        <a href="__WEB__?a=Member&c=Favorite&m=index">
            <span class="glyphicon glyphicon-folder-open"></span>
            我的收藏
        </a>
        <a href="__WEB__?a=Member&c=Follow&m=fans_list">
            <span class="glyphicon glyphicon-send"></span>
            我的粉丝
        </a><a href="__WEB__?a=Member&c=Follow&m=follow_list">
            <span class="glyphicon glyphicon-tower"></span>
            我的关注
        </a>
    </nav>
</section>