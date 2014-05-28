<?php
/**
 * 用户登录与注册模块
 * Class UserControl
 */
class LoginControl extends CommonControl {
	//登录
	public function login() {
		if (session('uid')) {
			go(U('Member/Index/index'));
		}
		if (IS_POST) {
			$Model = K("User");
			$code = Q('post.code', null, 'strtoupper');
			$username = Q('username');
			$password = Q('post.password', null, '');
			if (empty($code) || $code != $_SESSION['code']) {
				$this -> error = '验证码错误';
				$this -> display();
				exit ;
			}
			if (empty($username)) {
				$this -> error = '帐号不能为空';
				$this -> display();
				exit ;
			}
			if (empty($password)) {
				$this -> error = '密码不能为空';
				$this -> display();
				exit ;
			}
			$user = $Model -> where(array('username' => $username)) -> find();
			if (!$user) {
				$this -> error = "帐号不存在";
				$this -> display();
				exit ;
			}
			if ($user['password'] !== md5($password . $user['code'])) {
				$this -> error('密码输入错误');
				$this -> display();
			}
			setcookie('login', 1, 0, '/', C('SESSION_DOMAIN'));
			unset($user['password']);
			unset($user['code']);
			$_SESSION = array_merge($_SESSION, $user);
			if (empty($user['icon'])) {
				$_SESSION['icon'] = __ROOT__ . '/data/image/user/250.png';
			} else {
				$_SESSION['icon'] = __ROOT__ . '/' . $user['icon'];
			}
			$_SESSION['icon250'] = $_SESSION['icon'];
			$_SESSION['icon150'] = str_replace(250, 150, $_SESSION['icon250']);
			$_SESSION['icon100'] = str_replace(250, 100, $_SESSION['icon250']);
			$_SESSION['icon50'] = str_replace(250, 50, $_SESSION['icon250']);
			$Model -> save(array('uid' => $user['uid'], 'logintime' => time(), 'lastip' => ip_get_client()));
			go(U('Member/Index/index'));
		} else {
			$this -> display();
		}
	}

	//Ajax登录
	public function ajax_login() {
		if (IS_AJAX) {
			$Model = K("User");
			$username = Q("post.username", NULL, 'htmlspecialchars,strip_tags,addslashes');
			$password = Q('post.password', '', '');
			if (empty($username) || empty($password)) {
				$this -> error('用户名与密码不能为空');
			}
			$user = $Model -> where(array('username' => $username)) -> find();
			if (!$user) {
				$this -> error('帐号不存在');
			}
			if ($user['password'] !== md5($password . $user['code'])) {
				$this -> error('密码输入错误');
			}
			//是否锁定（限制时间）
			if (time() < $user['lock_end_time']) {
				$_SESSION['lock'] = true;
			}
			//验证IP是否锁定
			if ( M('user_deny_ip') -> where("ip='{$user['lastip']}'") -> find()) {
				$_SESSION['lock'] = true;
			}
			setcookie('login', 1, 0, '/', C('SESSION_DOMAIN'));
			unset($user['password']);
			unset($user['code']);
			$_SESSION = array_merge($_SESSION, $user);
			if (empty($user['icon'])) {
				$_SESSION['icon'] = __ROOT__ . '/data/image/user/250.png';
			} else {
				$_SESSION['icon'] = __ROOT__ . '/' . $user['icon'];
			}
			$_SESSION['icon250'] = $_SESSION['icon'];
			$_SESSION['icon150'] = str_replace(250, 100, $_SESSION['icon250']);
			$_SESSION['icon100'] = str_replace(250, 100, $_SESSION['icon250']);
			$_SESSION['icon50'] = str_replace(250, 50, $_SESSION['icon250']);
			//---------------------修改登录IP与时间
			$Model -> save(array("uid" => $_SESSION['uid'], "logintime" => time(), "lastip" => ip_get_client()));
			$this -> modifyMemberRole();
			$this -> success('登录成功');
		}
	}

	//会员登录后根据积分修改角色
	private function modifyMemberRole() {
		if ($_SESSION['admin'] == 0) {
			$Model = M('user');
			$pre = C("DB_PREFIX");
			$sql = "SELECT rid FROM {$pre}role WHERE admin=0 AND creditslower<=" . $_SESSION['credits'] . " ORDER BY creditslower DESC LIMIT 1";
			$role = $Model -> query($sql);
			$role = $role[0];
			if ($role['rid'] != $_SESSION['rid']) {
				$Model -> save(array('uid' => $_SESSION['uid'], 'rid' => $role['rid']));
			}
		}
	}

	//注册
	public function reg() {
		if (session('uid')) {
			go(U('Member/Index/index'));
		}
		//验证注册间隔时间
		$REG_INTERVAL = Q('session.REG_INTERVAL',0,'intval');
		if($REG_INTERVAL+C('REG_INTERVAL')>time()){
			$outTime= $REG_INTERVAL+C('REG_INTERVAL')-time();
			$this->error('请'.$outTime.'秒后注册');
		}
		if (IS_POST) {
			$Model = K("User");
			$code = Q('post.code', null, 'strtoupper');
			$username = Q('username');
			$email = Q('email', null, '');
			$password = Q('post.password', null, '');
			$passwordc = Q('post.passwordc', null, '');
			if (C('REG_SHOW_CODE') && (empty($code) || $code != $_SESSION['code'])) {
				$this -> error = '验证码错误';
				$this -> display();
				exit ;
			}
			if (empty($username)) {
				$this -> error = '帐号不能为空';
				$this -> display();
				exit ;
			}
			if (empty($email)) {
				$this -> error = '邮箱不能为空';
				$this -> display();
				exit ;
			}
			if (empty($password) || empty($passwordc)) {
				$this -> error = '密码不能为空';
				$this -> display();
				exit ;
			}
			if ($password !== $passwordc) {
				$this -> error = '两次密码输入不一致';
				$this -> display();
				exit ;
			}

			if ($Model -> where(array('username' => $username)) -> find()) {
				$this -> error = '帐号已经存在';
				$this -> display();
				exit ;
			}
			if ($Model -> where(array('email' => $email)) -> find()) {
				$this -> error = '邮箱已经使用';
				$this -> display();
				exit ;
			}
			$_POST['rid'] = C('default_member_group');
			//会员审核状态
			$_POST['user_state']=intval(C('MEMBER_VERIFY'));
			//邮件验证key
			$_POST['validatecode'] = substr(md5(time() . mt_rand(1, 1000)), -8);
			if ($Model -> addUser($_POST)) {
				//记录注册时间
				session('REG_INTERVAL',time());
				$user = $Model -> where(array('username' => $username)) -> find();
				setcookie('login', 1, 0, '/', C('SESSION_DOMAIN'));
				unset($user['password']);
				unset($user['code']);
				$_SESSION = array_merge($_SESSION, $user);
				$_SESSION['icon'] = __ROOT__ . '/data/image/user/250.png';
				$_SESSION['icon150'] = __ROOT__ . '/data/image/user/150.png';
				$_SESSION['icon100'] = __ROOT__ . '/data/image/user/100.png';
				$_SESSION['icon50'] = __ROOT__ . '/data/image/user/50.png';
				//发送验证邮件
				if (C('MEMBER_EMAIL_VALIDATE')) {
					go("Email/sendMail");
				}
				go(U('Member/Index/index'));
			} else {
				$this -> error = $Model -> error;
				$this -> display();
			}
		} else {
			$this -> display();
		}
	}

	//验证码
	public function code() {
		$code = new Code();
		$code -> show();
		exit ;
	}

	//退出登录
	public function quit() {
		//保留注册时间
		$REG_INTERVAL =$_SESSION['REG_INTERVAL'];
		$_SESSION=array();
		$_SESSION['REG_INTERVAL']=$REG_INTERVAL;
		setcookie('login', '', 1, '/');
		go(__ROOT__);
	}

}
