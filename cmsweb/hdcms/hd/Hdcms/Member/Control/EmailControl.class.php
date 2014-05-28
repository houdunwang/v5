<?php
/**
 * 会员邮箱设置
 * @author hdxj <houdunwangxj@gmail.com>
 */
class EmailControl extends Control {
	//构造函数
	public function __init() {
		//未登录
		if (!isset($_SESSION['uid'])) {
			go(U("Member/Login/login"));
		}
		if(M('user')->where(array('uid'=>$_SESSION['uid']))->getField('user_state')){
			$_SESSION['user_state']=1;
			go(U("Member/Index/index"));
		}
	}

	//发送验证邮件
	public function sendMail() {
		$_SESSION['sendtime'] = isset($_SESSION['sendtime']) ? $_SESSION['sendtime'] : time();
		$timeout = max($_SESSION['sendtime'] + 60 - time(),0);
		$_SESSION['timeout']=$timeout;
		if($timeout==0){
			$url = U("validateLoginEmail", array('username' => $_SESSION['username'], 'validatecode' => $_SESSION['validatecode']));
			$message = "请点击下面的链接或者把它复制到浏览器地址栏完成验证。<br/><a href='$url'>$url</a>";
			$state = Mail::send($_SESSION['email'], $_SESSION['username'], C('WEBNAME'), $message);
			$_SESSION['sendtime']=time();
			$_SESSION['timeout']=60;
		}
		go('VaifyMail');
	}

	//验证邮箱
	public function VaifyMail() {
		$message = "我们已经向" . $_SESSION['email'] . '发送验证邮件<br/>请登录邮箱点击确认链接即可激活帐号';
		$timeout= Q('session.timeout',0);
		$this -> assign('timeout', $timeout);
		$this -> assign('message', $message);
		$this -> display();
	}

	//用户点击验证邮件
	public function validateLoginEmail() {
		$username = Q('username');
		$validatecode = Q('get.validatecode');
		$Model = M("user");
		$user = $Model -> where(array('username' => $username)) -> find();
		if (empty($user['validatecode']) || $user['validatecode'] == $validatecode) {
			$Model -> where(array('username' => $username)) -> save(array('user_state' => 1));
			$this -> success('邮箱验证成功 !', U('Member/Index/index'));
		} else {
			$this -> error('邮箱验证失败... ', U('Member/Index/index'));
		}
	}

	//修改邮箱
	public function changeEmail() {
		if (IS_POST) {
			$email = Q('email');
			$Model = M('user');
			$User = $Model -> where("email='{$email}' AND uid<>{$_SESSION['uid']}") -> find();
			if ($User) {
				$this -> error('邮箱已经存在');
			} else {
				$Model -> where(array('uid' => $_SESSION['uid'])) -> save(array('email' => $email));
				$this -> success('修改成功', U('Member/Index/index'));
			}
		} else {
			$this -> display();
		}
	}

}
