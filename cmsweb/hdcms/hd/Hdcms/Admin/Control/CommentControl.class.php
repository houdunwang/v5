<?php
//评论管理
class CommentControl extends AuthControl
{
    private $_db;

    public function __init()
    {
        $this->_db = M("comment");
    }

    /**
     * 评论列表
     */
    public function index()
    {
    	$Model = M("comment");
        $comment_state = Q('get.comment_state', 1, 'intval');
        $count = $Model->where("comment_state=$comment_state")->count();
        $page = new Page($count, 15);
        $data = $Model->where("comment_state=$comment_state")->limit($page->limit())->order('comment_id DESC')->all();
		$this->assign('page',$page->show());
		$this->assign('data',$data);
        $this->display();
    }

    /**
     * 删除评论
     */
    public function del()
    {
        $comment_id = Q("request.comment_id");
        if (!empty($comment_id)) {
            if (!is_array($comment_id)) {
                $comment_id = array($comment_id);
            }
            foreach ($comment_id as $aid)
                $this->_db->del($aid);
            $this->_ajax(1, '删除成功');
        } else {
            $this->_ajax(0, '参数错误');
        }

    }

    /**
     * 审核或取消审核
     */
    public function audit()
    {
        //1 审核  0 取消审核
        $state = Q("state", 1, "intval");
        //文章id
        $comment_id = Q("post.comment_id");
        foreach ($comment_id as $id) {
            $this->_db->save(array("comment_id" => $id, "comment_state" => $state));
        }
        $this->_ajax(1, '操作成功！');
    }
}