<?php
//后台管理员登录与退出模块
class LoginControl extends Control{
	private $_db;
	public function __init(){
		$this->_db= M('admin');
	}
	//退出后台
	public function out(){
		$_SESSION=array();
		session_unset();
		session_destroy();
		//session(NULL);
		$this->success('退出成功','login');
	}
	//会员登录
	public function login(){
		if(session('aid'))
			go("Index/index");
		if(IS_POST){
			$username = Q("post.username");
			//对登录帐号的验证
			if(!$user = $this->_db->where("username='$username'")->find()){
				$this->error('帐号输入错误');
			}
			//对密码的验证
			if($user['password']!=md5($_POST['password'])){
				$this->error('密码输入错误');	
			}
			//当帐号密码输入正确时记录登录状态
			$_SESSION['aid']=$user['aid'];
			$_SESSION['username']=$user['username'];
			//跳转到后台界面
			go('Index/index');
		}else{
			//显示登录界面
			$this->display();	
		}
	}
	//登录时的验证码显示
	public function code(){
		//实例化验证码对象
		$code = new Code();
		//显示验证码
		$code->show();
	}
	//验证用户输入的验证码正确性
	public function checkCode(){
		//比对用户输入验证码正确性
		$stat = strtoupper($_POST['code'])==$_SESSION['code']?1:0;
		$this->ajax($stat);
	}
}