<?php
/**
 * 评论模型
 * Class CommentModel
 * @author hdxj <houdunwangxj@gmail.com>
 */
class CommentModel extends ViewModel {
	public $table = 'comment';
	public $auto = array(
		//添加评论时间
		array('pubtime', 'time', 'function', 2, 1),
		//评论uid
		array('uid', '_get_uid', 'method', 2, 3),
		//评论状态
		array('comment_state', '_get_comment_state', 'method', 2, 3)
	);
	//评论状态
	public function _get_comment_state() {
		return $_SESSION['comment_state'];
	}
	//获得用户uid
	public function _get_uid() {
		return session('uid');
	}
	//表关联
	public $view = array('user' => array('type' => INNER_JOIN, 'on' => 'comment.uid=user.uid'));
	//发表评论
	public function addComment() {
		if ($this -> create()) {
			return $this -> add();
		}
	}

}
