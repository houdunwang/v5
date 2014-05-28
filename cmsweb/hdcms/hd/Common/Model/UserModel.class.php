<?php

/**
 * 用户管理模型
 * Class UserModel
 */
class UserModel extends ViewModel {
	public $table = "user";
	public $view = array("role" => array("type" => INNER_JOIN, "on" => "user.rid=role.rid"));
	/**
	 * 删除用户
	 * @return mixed
	 */
	public function delUser($uid) {
		//删除评论与回复
		M('comment') -> where("uid=$uid") -> del();
		//删除用户表记录
		return $this -> del($uid);
	}

	/**
	 * 修改用户
	 */
	public function editUser($data) {
		//修改密码
		if (!empty($data['password'])) {
			$data['code'] = $this -> getUserCode();
			$data['password'] = md5($data['password'] . $data['code']);
		}else{
			unset($data['password']);
		}
		
		$uid = intval($data['uid']);
		return $this -> where("uid={$uid}") -> save($data);
	}

	/**
	 * 添加帐号
	 */
	public function addUser($data) {
		if (empty($data['username'])) {
			$this -> error = '用户名不能为空';
			return false;
		}
		if (empty($data['password'])) {
			$this -> error = '密码不能为空';
			return false;
		}
		$code = $this -> getUserCode();
		$data['code'] = $code;
		$data['password'] = md5($data['password'] . $data['code']);
		$data['nickname'] = $data['username'];
		$data['domain'] = substr(md5(mt_rand(1,1000).time().$data['username']),0,8);
		$data['regtime'] = time();
		$data['logintime'] = time();
		$data['regip'] = ip_get_client();
		$data['lastip'] = ip_get_client();
		$data['credits'] = C('init_credits');
		//设置用户头像
		if ($uid = $this -> add($data)) {
			return true;
		} else {
			$this -> error = '帐号注册失败';
			return false;
		}
	}

	/**
	 * 获取用户密码加密key
	 * @return string
	 */
	public function getUserCode() {
		return substr(md5(C("AUTH_KEY") . mt_rand() . time() . C('AUTH_KEY')), 0, 10);
	}

	/**
	 * 验证用户密码是否正确
	 * @param int uid 用户id
	 * @password 要比较的密码
	 */
	public function checkUserPassword($uid, $password) {
		$data = $this -> find($uid);
		if (!$uid) {
			$this -> error = '用户不存在';
			return false;
		}
		if (md5($password . $data['code']) != $data['password']) {
			return false;
		} else {
			return true;
		}

	}

}
