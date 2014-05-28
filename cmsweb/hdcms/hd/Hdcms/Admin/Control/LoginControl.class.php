<?php

/**
 * 登录处理模块
 * Class LoginControl
 * @author 向军 <houdunwangxj@gmail.com>
 */
class LoginControl extends CommonControl {
	
	/**
	 * 登录页面显示验证码
	 * @access public
	 */
	public function code() {
		C(array("CODE_BG_COLOR" => "#ffffff", "CODE_LEN" => 4, "CODE_FONT_SIZE" => 20, "CODE_WIDTH" => 120, "CODE_HEIGHT" => 35, ));
		$code = new Code();
		$code -> show();
	}

	/**
	 * 用户登录处理
	 * @access public
	 */
	public function Login() {
		if (IN_ADMIN || WEB_MASTER) {
			go(__APP__);
			exit ;
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
			setcookie('login', 1, 0, '/');
			unset($user['password']);
			unset($user['code']);
			//是否为超级管理员
			
			$_SESSION = array_merge($_SESSION, $user);
			if (empty($user['icon'])) {
				$_SESSION['icon'] = __ROOT__.'/data/image/user/250.png';
			}else{
				$_SESSION['icon']=__ROOT__.'/'.$user['icon'];
			}
			$_SESSION['icon250'] = $_SESSION['icon'];
			$_SESSION['icon150'] = str_replace(250, 150, $_SESSION['icon250']);
			$_SESSION['icon100'] = str_replace(250, 100, $_SESSION['icon250']);
			$_SESSION['icon50'] = str_replace(250, 50, $_SESSION['icon250']);
			$Model -> save(array('uid' => $user['uid'], 'logintime' => time(), 'lastip' => ip_get_client()));
			go(__APP__);
		} else {
			$this -> display();
		}
	}

	/**
	 * 退出
	 */
	public function out() {
		//清空SESSION
		session_unset();
		session_destroy();
		setcookie('login', '', 1, '/');
		echo "<script>
            window.top.location.href='" . U("login") . "';
        </script>";
		exit ;
	}

}
