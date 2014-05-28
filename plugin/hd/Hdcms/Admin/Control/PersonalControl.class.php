<?php

/**
 * 管理员个人信息管理模块
 * Class AdminControl
 * @author 向军 <houdunwangxj@gmail.com>
 */
class PersonalControl extends AuthControl {
	//操作模型
	private $_db;

	//构造函数
	public function __init() {
		$this -> _db = K('User');
	}

	/**
	 * 编辑个人信息
	 */
	public function edit_info() {
		if (IS_POST) {
			if ($this -> _db -> where("uid=" . session('uid')) -> save()) {
				$this -> _ajax(1, '修改个人资料成功');
			}
		} else {
			$this -> user = $this -> _db -> find(session('uid'));
			$this -> display();
		}
	}

	/**
	 * 修改密码
	 */
	public function edit_password() {
		if (IS_POST) {
			$_POST['uid']=session('uid');
			if ($this -> _db -> editUser($_POST)) {
				$this -> success('修改密码成功');
			}else{
				$this->error($htis->_db->error);
			}
		} else {
			$this -> user = $this -> _db -> find(session('uid'));
			$this -> display();
		}
	}

	/**
	 * 修改密码操作时Ajax验证密码
	 */
	public function check_password() {
		if ($this -> _db -> checkUserPassword(session('uid'), $_POST['old_password'])) {
			echo 1;
		} else {
			echo 0;
		}
		exit ;
	}

	//验证邮箱
	public function check_email() {
		$email = Q("post.email");
		if ($uid = Q('uid')) {
			$this -> _db -> where("uid<>$uid");
		}
		echo $this -> _db -> join() -> find("email='$email'") ? 0 : 1;
		exit ;
	}

}
