<?php

/**
 * 会员中心权限控制
 * Class MemberAuthControl
 */
class MemberAuthControl extends CommonControl {
	//构造函数
	public function __construct() {
		parent::__construct();
		if (!$this -> checkAccess()) {
			$this -> error("没有操作权限");
		}
		//消息数
		$message_count = M("user_message") -> where(array('to_uid' => $_SESSION['uid'], 'user_message_state' => 0)) -> count();
		$this -> assign('message_count', $message_count);
		//信息信息
		$systemmessage_count=M("system_message") -> where(array('uid' => $_SESSION['uid'], 'state' => 0)) -> count();
		$this -> assign('systemmessage_count', $systemmessage_count);
	}

	//验证
	public function checkAccess() {
		//未登录
		if (!IS_LOGIN) {
			go(U("Member/Login/login"));
		}
		//状态
		if(!USER_STATE){
			$this->error('帐号审核中...');
		}
		//锁定
		if(IS_LOCK){
			$this->error('帐号已锁定...');
		}
		//管理员
		if (WEB_MASTER || IN_ADMIN) {
			return true;
		}
		//会员中心关闭
		if (C("MEMBER_OPEN") == 0) {
			$this -> display("template/system/member_close.html");
			exit ;
		}
		//邮箱验证
		if (C('MEMBER_EMAIL_VALIDATE') && $_SESSION['user_state'] == 0) {
			go(U('Member/Email/VaifyMail'));
		}
		return true;
	}

}
