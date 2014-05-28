<?php

/**
 * Class CommonControl
 * 发表评论
 */
class CommentControl extends CommonControl
{
    //模型
    private $_db;
    //模型mid
    private $_mid;
    //栏目cid
    private $_cid;
    //文章aid
    private $_aid;

    //构造函数
    public function __init()
    {
        $this->_db = K("Comment");
        $this->_mid = Q('mid', null, 'intval');
        $this->_cid = Q('cid', null, 'intval');
        $this->_aid = Q('aid', null, 'intval');
        //栏目与文章aid必须存在
        if (!$this->_cid || !$this->_aid) {
            _404('参数错误');
        }
    }

    //显示评论列表
    public function index()
    {
        if (!$this->isCache()) { //缓存是否失效
            $data = $this->_db->get_comment();
            $this->assign($data);
        }
        $this->display('index.php', 10);
    }

    //显示文章评论
    public function show()
    {
        $data = $this->_db->get_comment();
        $this->assign($data);
        $con = $this->fetch('index.php');
        if (Q('page')) {
            echo $con;
        } else {
            echo "document.write('<div id=\"hdcomment\">" . preg_replace('@\r|\n@mi', '', addslashes($con)) . "</div>')";
        }
        exit;
    }

    /**
     * 添加评论
     */
    public function add_comment()
    {
        if (!session("uid")) {
            $this->_ajax('nologin', '没有登录');
        } else {
            //---------------------------------------验证评论发表间隔时间
            Q('session.comment_send_time', 0, 'intval');
            //间隔时间小于配置项
            if ($_SESSION['admin']==0 && Q('session.comment_send_time') + C('comment_step_time') > time()) {
                $_time = Q('session.comment_send_time') + C('comment_step_time') - time();
                $step = $_time / 60 > 1 ? intval($_time / 60) . '分钟' : $_time . '秒';
                $this->_ajax(0, '请' . $step . '后发表');
            }
            //----------------------------------验证内容重复
            $content = Q('content', '');
            if (!trim($content)) {
                $this->_ajax(0, '评论内容不能为空');
            }
            $data = $this->_db->
                where("cid={$this->_cid} && aid={$this->_aid} && " . C("DB_PREFIX") . "comment.uid=" . session('uid'))
                ->where("content='$content'")
                ->order("comment_id DESC")->find();
            if ($data) {
                $this->_ajax(0, '请不要发表重复内容');
            }
			//----------------------------------------添加积分
			$reply_credits = intval(C('reply_credits'));
			$credits_msg = '';
			if($reply_credits){
				$sql = "UPDATE ".C('DB_PREFIX').'user AS u SET credits=credits+'.$reply_credits;
				M()->exe($sql);
				$_SESSION['credits']+=$reply_credits;
				$credits_msg='奖励'.$reply_credits.'个积分';
			}
            //-----------------------------------------发表评论
            $_POST['content'] = $content;
            if ($comment_id = $this->_db->add_comment()) {
                $comment = $this->get_one($comment_id);
                $msg = C('comment_state') == 1 || session('admin')==1 ? '评论成功！'.$credits_msg : '评论成功，审核后显示';
                //记录发表时间
                session('comment_send_time', time());
                //------------------------------------添加动态
                $content ="发表了评论: " .mb_substr($content, 0, 30, 'utf-8');
                $this->add_dynamic($content);
                $this->_ajax(1, $msg, $comment);
            } else {
                $this->_ajax(0, '失败了哟');
            }
        }
    }

    /**
     * 验证评论发表间隔时间
     */
    public function check_comment_step()
    {
        $result = $this->_db->
            where("cid={$this->_cid} && aid={$this->_aid} && " . C("DB_PREFIX") . "comment.uid=" . session('uid'))->order("comment_id DESC")
            ->find();
        if ($result) {
            return $result['pubtime'] + C('comment_step_time') < time();
        } else {
            return false;
        }
    }

    /**
     * 获得刚刚发表的评论用于显示
     * @param $comment_id 评论comment_id
     * @return string
     */
    public function get_one($comment_id)
    {
        $data = $this->_db->get_one($comment_id);
        $comment = <<<str
<li>
                    <div class="hd-comment-face">
                         <a href="?{$data['username']}"><img src="{$data['icon']}"/></a>
                    </div>
                    <div class="hd-comment-content">
                        {$data['content']}
                        <div class="hd-author-info">
                            <span class="hd-comment-author">
                                <a href="?{$data['username']}"> {$data['username']}</a>&nbsp;&nbsp;
                            </span>
                            刚刚
                        </div>
                    </div>
</li>
str;
        return $comment;
    }

}






















