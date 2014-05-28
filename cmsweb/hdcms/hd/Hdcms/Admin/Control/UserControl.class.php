<?php
/**
 * 会员管理
 * @author hdxj <houdunwangxj@gmail.com>
 */
class UserControl extends AuthControl {
	//会员列表
	public function index() {
		$Model = K('User');
		$WEBMASTER = C('WEB_MASTER');
		$this -> data = $Model-> order("uid ASC") -> where("username<>'$WEBMASTER'") -> all();
		$this -> display();
	}

	//验证用户是否存在
	public function check_username() {
		$Model = M('user');
		$username = Q("post.username");
		echo  $Model-> find("username='$username'") ? 0 : 1;
		exit ;
	}

	//验证邮箱
	public function check_email() {
		$Model = M('user');
		$email = Q("email");
		$where='';
		if ($uid = Q('uid')) {
			$where="uid<>$uid";
		}
		echo $Model->where($where)-> find("email='$email'") ? 0 : 1;
		exit ;
	}

	//删除
	public function del() {
		if (IS_POST) {
			$uid = Q('uid', 0, 'intval');
			//删除文章
			if (Q('post.delcontent')) {
				$ModelCache = cache('model');
				foreach ($ModelCache as $model) {
					$contentModel = ContentModel::getInstance($model['mid']);
					$contentModel -> where(array('uid' => $uid)) -> del();
				}
			}
			//删除评论
			if (Q('post.delcomment')) {
				M('comment') -> where(array('uid' => $uid)) -> del();
			}
			//删除附件
			if (Q('post.delupload')) {
				M('upload') -> where(array('uid' => $uid)) -> del();
			}
			//删除用户
			M('user') -> del($uid);
			$this -> success('删除成功...');
		} else {
			$uid = Q("uid", 0, "intval");
			$field = M('user') -> find($uid);
			$this -> assign('field', $field);
			$this -> display();
		}
	}

	//添加
	public function add() {
		if (IS_POST) {
			$Model=K('User');
			if ($Model-> addUser($_POST)) {
				$this -> success("添加成功！");
			} else {
				$this -> error($Model-> error);
			}
		} else {
			$this -> role = M("role") -> order("rid DESC") -> all();
			$this -> display();
		}
	}

	//修改
	public function edit() {
		$Model = K('User');
		if (IS_POST) {
			$_POST['lock_end_time']=Q('lock_end_time',NOW,'strtotime');
			if ($Model-> editUser($_POST)) {
				$this -> success("修改成功！");
			} else {
				$this -> error($Model-> error);
			}
		} else {
			$uid = Q("uid",0, "intval");
			if ($uid) {
				$field = $Model-> find($uid);
				$role = M("role") -> order("rid DESC") -> all();
				$this->assign('field',$field);
				$this->assign('role',$role);
				$this -> display();
			}
		}
	}

	//锁定与解锁
	public function lock() {
		$lock = Q('lock', 1, 'intval');
		if($lock){
			$lock_end_time=time()+3600*24*365*10;	
		}else{
			$lock_end_time=0;
		}
		$uid = Q('uid', 0, 'intval');
		
		M('user') -> where(array('uid' => $uid)) -> save(array('lock_end_time' => $lock_end_time));
		$this -> success('操作成功 ');
	}
}
