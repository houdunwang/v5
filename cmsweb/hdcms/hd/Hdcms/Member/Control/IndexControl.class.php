<?php

/**
 * 会员中心
 * Class HomeControl
 */
class IndexControl extends CommonControl {

	/**
	 * 会员中心首页
	 */
	public function index() {
		if (isset($_SESSION['uid'])) {
			go(U('Member/Dynamic/index'));
		} else {
			go(U('Member/Login/login'));
		}
	}

	//显示会员登录框
	public function Member() {
		if (session('uid')) {
			$message_count = M("user_message") -> where(array('to_uid' => $_SESSION['uid'], 'user_message_state' => 0)) -> count();
			$this -> assign('message_count', $message_count);
		}
		$con = preg_replace('@\n|\r@', '', ($this -> fetch()));
		echo "document.write('$con');";
		exit ;
	}

}
