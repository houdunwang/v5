<link rel="stylesheet" type="text/css" href="__CONTROL_TPL__/css/comment.css?ver=1.0"/>
<js file="__CONTROL_TPL__/js/comment.js"/>
<script>
 	var WEB='__WEB__';
    $(function(){
    	//跳转到指定的评论
        var comment_id = '{$hd.get.comment_id|default:0}';
        if(comment_id){
            var id = 'c'+comment_id;
            var _top = $("#"+id).offset().top;
            $(window).scrollTop(_top);
        }
    })
</script>
<!--发表评论-->
<div class="hd-comment">
    <!--评论标题-->
    <div class="title">
        <img src="{$hd.session.icon|default:'__ROOT__/data/image/user/50-gray.png'}"/> 发表我的评论
    </div>
    <!--发表评论-->
    <div class="publish">
        <form method="post" onsubmit="return add_comment(this)">
            <input type="hidden" name="mid" value="{$hd.get.mid}"/>
            <input type="hidden" name="cid" value="{$hd.get.cid}"/>
            <input type="hidden" name="aid" value="{$hd.get.aid}"/>
            <input type="hidden" name="pid" value="0"/>
            <textarea name="content" placeholder="写点什么..." name="content"></textarea>
            <input type="submit" value="提交评论" class="comment-submit"/>
        </form>
    </div>
    <!--评论列表-->
    <div class="hd-comment-list">
        <ol class="comment-list">
            <list from="$data" name="a">
                <li id="c{$a.comment_id}">
                    <div class="hd-comment-face">
                        <a href="__WEB__?{$a.domain}">
                        <img src="{$a.icon}"  onmouseover="user.show(this,{$a.uid})"/>
                            </a>
                    </div>
                    <div class="hd-comment-content">
                        {$a.content}
                        <div class="hd-author-info">
                            <span class="hd-comment-author">
                                <a href="__WEB__?{$a.domain}">{$a.nickname}</a>&nbsp;&nbsp;
                            </span>
                            {$a.pubtime|date:"Y-m-d H:i",@@} ({$a.pubtime|date_before})
                            <a class="comment-reply-link" href="javascript:;">回复 </a>
                        </div>
                    </div>
                    <!--回复-->
                    <div class="hd-comment-reply">
                        <div class="hd-comment-face">
                            <img src="{$hd.session.icon50}"/>
                        </div>
                        <div class="hd-reply-content">
                            <form method="post" onsubmit="return add_comment(this,'reply')">
                                <input type="hidden" name="mid" value="{$a.mid}"/>
                                <input type="hidden" name="cid" value="{$a.cid}"/>
                                <input type="hidden" name="aid" value="{$a.aid}"/>
                                <input type="hidden" name="pid" value="{$a.comment_id}"/>
                                <input type="hidden" name="reply_comment_id" value="{$a.comment_id}"/>
                                <textarea name="content" placeholder="写点什么..."></textarea>
                                <input type="submit" value="发表评论" class="comment-submit"/>
                                <input type="button" value="取消评论" class="comment-cancel"/>
                            </form>
                        </div>
                    </div>
                    <!--子评论-->
                    <ul class="children">
                        <list from="$a._data" name="b">
                            <li id="c{$b.comment_id}">
                                <div class="hd-comment-face">
                                    <a href="__WEB__?{$b.domain}">
                                    <img src="{$b.icon}"  onmouseover="user.show(this,{$b.uid})"/>
                                        </a>
                                </div>
                                <div class="hd-comment-content">
                                    {$b.content}
                                    <div class="hd-author-info">
                            <span class="hd-comment-author">
                                <a href="__WEB__?{$b.domain}">{$b.nickname}</a>&nbsp;&nbsp;
                            </span>
                                        {$b.pubtime|date:"Y-m-d H:i",@@} ({$b.pubtime|date_before})
                                        <a class="comment-reply-link" href="javascript:;">回复 </a>
                                    </div>
                                </div>
                                <!--回复-->
                                <div class="hd-comment-reply">
                                    <div class="hd-comment-face">
                                        <img src="{$hd.session.icon50}"/>
                                    </div>
                                    <div class="hd-reply-content">
                                        <form method="post" onsubmit="return add_comment(this,'reply')">
                                            <input type="hidden" name="mid" value="{$b.mid}"/>
                                            <input type="hidden" name="cid" value="{$b.cid}"/>
                                            <input type="hidden" name="aid" value="{$b.aid}"/>
                                            <input type="hidden" name="pid" value="{$b.comment_id}"/>
                                            <input type="hidden" name="reply_comment_id" value="{$a.comment_id}"/>
                                            <textarea name="content" placeholder="写点什么..."></textarea>
                                            <input type="submit" value="发表评论" class="comment-submit"/>
                                            <input type="button" value="取消评论" class="comment-cancel"/>
                                        </form>
                                    </div>
                                </div>
                                <ul class="children">
                                    <list from="$b._data" name="c">
                                        <li class="bg-white" id="c{$c.comment_id}">
                                            <div class="hd-comment-face">
                                                <a href="__WEB__?{$c.domain}">
                                                <img src="{$c.icon}"  onmouseover="user.show(this,{$c.uid})"/>
                                                    </a>
                                            </div>
                                            <div class="hd-comment-content">
                                                {$c.content}
                                                <div class="hd-author-info">
                                                <span class="hd-comment-author">
                                                    <a href="__WEB__?{$c.domain}">{$c.nickname}</a>&nbsp;&nbsp;
                                                </span>
                                                    {$c.pubtime|date:"Y-m-d H:i",@@} ({$c.pubtime|date_before})
                                                    <a class="comment-reply-link" href="javascript:;">回复 </a>
                                                </div>
                                            </div>
                                            <!--回复-->
                                            <div class="hd-comment-reply">
                                                <div class="hd-comment-face">
                                                    <img src="{$hd.session.icon50}"/>
                                                </div>
                                                <div class="hd-reply-content">
                                                    <form method="post" onsubmit="return add_comment(this,'reply')">
                                                        <input type="hidden" name="mid" value="{$c.mid}"/>
                                                        <input type="hidden" name="cid" value="{$c.cid}"/>
                                                        <input type="hidden" name="aid" value="{$c.aid}"/>
                                                        <input type="hidden" name="pid" value="{$c.comment_id}"/>
                                                        <input type="hidden" name="reply_comment_id"
                                                               value="{$a.comment_id}"/>
                                                        <textarea name="content" placeholder="写点什么..."></textarea>
                                                        <input type="submit" value="发表评论" class="comment-submit"/>
                                                        <input type="button" value="取消评论" class="comment-cancel"/>
                                                    </form>
                                                </div>
                                            </div>
                                            <ul class="children">
                                                <list from="$c._data" name="d">
                                                    <li id="c{$d.comment_id}">
                                                        <div class="hd-comment-face">
                                                            <a href="__WEB__?{$d.domain}">
                                                            <img src="{$d.icon}"  onmouseover="user.show(this,{$d.uid})"/>
                                                                </a>
                                                        </div>
                                                        <div class="hd-comment-content">
                                                            {$d.content}
                                                            <div class="hd-author-info">
                                                            <span class="hd-comment-author">
                                                                <a href="__WEB__?{$d.domain}">{$d.nickname}</a>&nbsp;&nbsp;
                                                            </span>
                                                                {$d.pubtime|date:"Y-m-d H:i",@@}
                                                                ({$d.pubtime|date_before})
                                                            </div>
                                                        </div>
                                                    </li>
                                                </list>
                                            </ul>
                                        </li>
                                    </list>
                                </ul>
                            </li>
                        </list>
                    </ul>
                </li>
            </list>
        </ol>
    </div>
    <div class="page">
        {$page}
    </div>
</div>
<div class="comment_alter">
    发表成功了哟！
</div>




